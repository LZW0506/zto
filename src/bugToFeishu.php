<?php

namespace Lzw\ZentaoToOther;

use Illuminate\Support\Facades\Log;

class bugToFeishu
{
    /**
     * bug信息整理格式
     * @param $bugsInfo
     * @return array
     */
    public function bugInfo($bugsInfo): array
    {
        return [
            "id" => $bugsInfo['id'] ?? '',
            "标题" => $bugsInfo['title'] ?? '',
            "所属项目" => $bugsInfo['projectName'] ?? '',
            "所属产品" => $bugsInfo['productName'] ?? '',
            "所属模块" => $bugsInfo['moduleTitle'] ?? '',
            "bug状态" => $this->bugKey($bugsInfo['status'],'bug_status'),
            "优先级" => $this->bugKey($bugsInfo['pri'],'pri'),
            "严重程度" => $this->bugKey($bugsInfo['severity'],'severity'),
            "类型" => $this->bugKey($bugsInfo['type'],'type'),
            "由谁创建" => is_array($bugsInfo['openedBy']) ? $bugsInfo['openedBy']['realname'] : '',
            "创建时间" => empty($bugsInfo['openedDate']) ? null : strtotime($bugsInfo['openedDate']) * 1000,
            "当前指派" => is_array($bugsInfo['assignedTo']) ? $bugsInfo['assignedTo']['realname'] : '',
            "指派时间" => empty($bugsInfo['assignedDate']) ? null : strtotime($bugsInfo['assignedDate']) * 1000,
            "由谁解决" => is_array($bugsInfo['resolvedBy']) ? $bugsInfo['resolvedBy']['realname'] : '',
            "解决时间" => empty($bugsInfo['resolvedDate']) ? null : strtotime($bugsInfo['resolvedDate']) * 1000,
            "由谁关闭" => is_array($bugsInfo['closedBy']) ? $bugsInfo['closedBy']['realname'] : '',
            "关闭时间" => empty($bugsInfo['closedDate']) ? null : strtotime($bugsInfo['closedDate']) * 1000,
        ];
    }
    /**
     * 创建或更新bug
     * @param $bugsInfo
     */
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
    /**
     * 更新bug
     * @param $bugsInfo
     * @param $record_id
     */
    private function update($bugsInfo,$record_id): void
    {
        $feishuSdk = new FeishuSdk();
        $app_token = config('zto.feishu.app_token');
        $table_id = $feishuSdk->getDataTableId();
        $update =  $feishuSdk->feishuHttp()->put("/open-apis/bitable/v1/apps/{$app_token}/tables/{$table_id}/records/{$record_id}",["fields"=>$bugsInfo])->json();
        if ($update['code'] !== 0) {
            Log::error($update);
        }
    }
    /**
     * 创建bug
     * @param $bugsInfo
     */
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

    /**
     * bug状态转换
     * @param $string
     * @param string $configKey
     * @return mixed|string
     */
    private function bugKey($string,$configKey): mixed
    {
        $config = config("zto.feishu.table_info.{$configKey}");
        return $config[$string] ?? '';
    }


}
