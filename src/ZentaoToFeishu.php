<?php

namespace Lzw\ZentaoToOther;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ZentaoToFeishu
{

    function __construct(array|null $config = null)
    {
        $this->config = $config ?? config('zentao');
    }

}
