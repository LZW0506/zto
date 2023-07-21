<?php

namespace Lzw\ZentaoToOther;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ZentaoToOther
{


    /**
     * 禅道通用api接口
     * @param array|null $config
     * @param array $headers
     * @return PendingRequest
     * @throws Exception
     */
    public function zentaoHttp(array|null $config = null, array $headers = [])
    {
        try {
            $zentaoSdk = new ZentaoSdk($config);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $zentaoSdk->zentaoHttp($headers);
    }

    /**
     * 飞书通用api接口
     * @return PendingRequest
     * @throws Exception
     */
    public function feishuHttp()
    {
        try {
            $zentaoSdk = new FeishuSdk();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $zentaoSdk->feishuHttp();
    }

    /**
     * zentaoSdk
     * @param array|null $config
     * @return ZentaoSdk
     */
    public function zentaoSdk(array|null $config = null)
    {
        return new ZentaoSdk($config);
    }


    /**
     * feishuSdk
     * @return FeishuSdk
     */
    public function feishuSdk()
    {
        return new FeishuSdk();
    }

    public function zentaoHook($message)
    {
        $zentaoSdk = new ZentaoSdk();
        if ($message['objectType'] === 'bug') {
            $bugsInfo = $zentaoSdk->zentaoHttp()->get("/bugs/{$message['objectID']}")->json();
            $bugToFeishu = new bugToFeishu;
            $bugInfo = $bugToFeishu->bugInfo($bugsInfo);
            $bugToFeishu->createOrUpdate($bugInfo);

        }
    }



    /**
     * 创建飞书数据表
     * @return array
     * @throws Exception
     */
    public function createFeishuTable(): array
    {
        $feishuSdk = new FeishuSdk();
        $table_id = $feishuSdk->getDataTableId();
        if (empty($table_id)) {
            $createTableData = require("createFeishuTbale.php");
            // 创建数据表
            $app_token = config('zto.feishu.app_token');
            $createTable = $feishuSdk->feishuHttp()->post("open-apis/bitable/v1/apps/{$app_token}/tables", $createTableData)->json();
            if ($createTable['code'] !== 0) {
                return $createTable;
            }
            Cache::set('feishu_data_table_id', $createTable['data']['table_id']);
            return [...$createTable, 'remark' => '请将table_id配置到.env文件中的 FEISHU_DATA_TABLE_ID 上以防丢失'];
        }
        return $this->success(['data_table_id' => $table_id]);

    }


    private function success($data = [], $msg = 'success'): array
    {
        return ['code' => 0, 'msg' => $msg, 'data' => $data];
    }

    private function error($msg = 'error', $code = 1): array
    {
        return ['code' => $code, 'msg' => $msg];
    }


}
