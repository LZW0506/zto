<?php

namespace Lzw\ZentaoToOther;

use Exception;
use Illuminate\Http\Client\PendingRequest;

class ZentaoToOther
{

    public function __construct()
    {

    }

    /**
     * 禅道通用api接口
     * @param array|null $config
     * @param array $headers
     * @return PendingRequest
     * @throws Exception
     */
    public function zentaoSdk(array|null $config = null,array $headers=[])
    {
        try {
            $zentaoSdk = new ZentaoSdk($config);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $zentaoSdk->zentaoHttp($headers);
    }
}
