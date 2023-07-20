<?php

namespace Lzw\ZentaoToOther;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ZentaoSdk
{
    private array|null $config;
    private string|null $token;

    private string $url;

    /**
     * ZentaoSdk constructor.
     * @param array|null $config
     * @throws \Exception
     */
    function __construct(array|null $config = null)
    {
        $this->config = $config ?? config('zto');
        if(empty($this->config['url'])){
            throw new \Exception('zentao url is null');
        }
        $this->url = $this->config['url'].'/api.php/v1/';
        $this->getToken();
    }

    /**
     * 获取token
     * @return array
     * @throws \Exception
     */
    public function getToken(): array
    {
        if(empty($this->config['account'])){
            throw new \Exception('zentao account is null');
        }
        if(empty($this->config['password'])){
            throw new \Exception('zentao password is null');
        }
        $data = [
            'account' => $this->config['account'],
            'password' => $this->config['password'],
        ];
        $result = $this->zentaoHttp()->post('tokens', $data);
        $resultJson = $result->json();
        if(isset($resultJson['error'])){
            return $resultJson;
        }
        $this->token = $resultJson['token'];
        return  $resultJson;
    }

    /**
     * 禅道http客户端
     * @param array $headers
     * @return PendingRequest
     */
    function zentaoHttp(array $headers=[])
    {
        if(isset($this->token)){
            $headers['token'] = $this->token;
        }
        $response = Http::baseUrl($this->url);
        if(sizeof($headers) > 0){
            $response = $response->withHeaders($headers);
        }
        return $response;
    }


}
