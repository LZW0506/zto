<?php

namespace Lzw\ZentaoToOther;

use Illuminate\Support\Facades\Log;

class bugToFeishu
{
    public function bugInfo($bugsInfo): array
    {
        return [
            "id" => $bugsInfo['id'],
            "标题" => $bugsInfo['title'],
            "bug状态" => $this->bugStatus($bugsInfo['status']),
            "严重程度" => $this->severity($bugsInfo['severity']),
            "类型" => $this->type($bugsInfo['type']),
            "由谁创建" => is_array($bugsInfo['openedBy']) ? $bugsInfo['openedBy']['realname'] : '',
            "创建时间" => empty($bugsInfo['openedDate']) ? null : strtotime($bugsInfo['openedDate']) * 1000,
            "当前指派" => is_array($bugsInfo['assignedTo']) ? $bugsInfo['assignedTo']['realname'] : '',
            "指派时间" => empty($bugsInfo['assignedDate']) ? null : strtotime($bugsInfo['assignedDate']) * 1000,
            "由谁解决" => is_array($bugsInfo['resolvedBy']) ? $bugsInfo['resolvedBy']['realname'] : '',
            "解决时间" => empty($bugsInfo['closedDate']) ? null : strtotime($bugsInfo['resolvedDate']) * 1000,
            "由谁关闭" => is_array($bugsInfo['closedBy']) ? $bugsInfo['closedBy']['realname'] : '',
            "关闭时间" => empty($bugsInfo['closedDate']) ? null : strtotime($bugsInfo['closedDate']) * 1000,
        ];
    }

    public function createOrUpdate($bugsInfo): void
    {
        Log::info($bugsInfo);
        $feishuSdk = new FeishuSdk();
        $table_id = $feishuSdk->getDataTableId();
        $app_token = config('zto.feishu.app_token');
        $fileterById = $feishuSdk->feishuHttp()->get("open-apis/bitable/v1/apps/{$app_token}/tables/{$table_id}/records", [
            "filter" => "CurrentValue.[id] = {$bugsInfo['id']}"
        ])->json();
        if ($fileterById['code'] !== 0) {
            Log::error($fileterById);
        }else{
            if(is_array($fileterById['data']['items']) && sizeof($fileterById['data']['items']) >0){
                $this->update($bugsInfo,$fileterById['data']['items'][0]['record_id']);
            }else{
                $this->create($bugsInfo);
            }
        }
    }

    private function update($bugsInfo,$record_id)
    {
        $feishuSdk = new FeishuSdk();
        $app_token = config('zto.feishu.app_token');
        $table_id = $feishuSdk->getDataTableId();
        $update =  $feishuSdk->feishuHttp()->put("/open-apis/bitable/v1/apps/{$app_token}/tables/{$table_id}/records/{$record_id}",["fields"=>$bugsInfo])->json();
        if ($update['code'] !== 0) {
            Log::error($update);
        }
    }

    private function create($bugsInfo): void
    {
        $feishuSdk = new FeishuSdk();
        $app_token = config('zto.feishu.app_token');
        $table_id = $feishuSdk->getDataTableId();
        $create = $feishuSdk->feishuHttp()->post("open-apis/bitable/v1/apps/{$app_token}/tables/{$table_id}/records", [
            "fields" => $bugsInfo
        ])->json();
        if ($create['code'] !== 0) {
            Log::error($create);
        }
    }

    private function severity($data): string
    {
        return match ($data) {
            1 => '严重',
            2 => '高',
            3 => '中',
            4 => '低',
            5 => '建议',
            default => '',
        };
    }

    private function bugStatus($data): string
    {
        return match ($data) {
            "active" => '激活',
            "resolved" => '已解决',
            "closed" => '已关闭',
            default => '',
        };
    }

    private function type($data): string
    {
        return match ($data) {
            "codeerror" => '代码错误',
            "1" => '与原型不符',
            "config" => '功能优化',
            "install" => '原型优化',
            "security" => '界面问题',
            "performance" => '性能问题',
            "standard" => '需求变更',
            "automation" => '安全相关',
            "designdefect" => '设计缺陷',
            "others" => '其他',
            "suggest" => '优化建议',
            default => '',
        };
    }
}
