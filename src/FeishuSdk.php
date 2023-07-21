<?php

namespace Lzw\ZentaoToOther;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FeishuSdk
{

    private string $url = 'https://open.feishu.cn/';

    private string $token;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        try {
            $this->getToken();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 获取飞书token
     * @return array
     * @throws \Exception
     */
    public function getToken(): array
    {
        if (Cache::has('feishuToken')) {
            $this->token = Cache::get('feishuToken');
            return ['token' => $this->token];
        }
        $data = [
            'app_id' => config('zto.feishu.app_id'),
            'app_secret' => config('zto.feishu.app_secret'),
        ];
        $result = $this->feishuHttp()->post('open-apis/auth/v3/tenant_access_token/internal', $data);
        $resultJson = $result->json();
        if ($resultJson['code'] !== 0) {
            throw new \Exception('feishu token error:' . json_encode($resultJson));
        }
        $this->token = $resultJson['tenant_access_token'];
        Cache::put('feishuToken', $resultJson['tenant_access_token'], 600);
        return $resultJson;
    }

    /**
     * 飞书通用api接口
     * @return PendingRequest
     */
    function feishuHttp(): PendingRequest
    {
        $headers = [];
        if (isset($this->token)) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }
        $headers['Content-Type'] = 'application/json; charset=utf-8';
        return Http::baseUrl($this->url)->withHeaders($headers);
    }
    function getDataTableId()
    {
        $table_id = config('zto.feishu.data_table_id');
        if (empty($table_id)) {
            $table_id = Cache::get('feishu_data_table_id');
        }
        return $table_id;
    }
}
