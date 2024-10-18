<?php

namespace App\Traits;

use App\Helpers\Helper;
use Illuminate\Support\Facades\App;

trait ClearFrontendCache
{
    public static $clearFrontendCache = true;

    public static function clearFrontendCache($create = false)
    {
        App::terminating(function () {
            Helper::ApiRequest('/api/v1/clear-cache');
        });
    }
}
