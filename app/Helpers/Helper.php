<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;

class Helper
{
    //// constants //////
    public const STATUS_ACTIVE   = 1;
    public const STATUS_DEACTIVE = 0;

    public const STORAGE_LOCATION_LOCAL = 'local';
    public const STORAGE_LOCATION_CLOUD = 's3';


    private static $transactionResult = NULL;

    public static function getApiHost()
    {
        return env('FRONTEND_APP_URL');
    }

    ///////// file related methods ////////
    public static function uploadToLocal(string $path,  $file, $disk = 'public')
    {
        static::safeBlock(function () use ($path, $file, $disk) {
            return '/storage/' . Storage::disk($disk)->put($path, $file);
        });
        return static::getTransactionResult();
    }

    public static function fileUrl(string | null | bool $file): string | bool
    {
        static::safeBlock(function () use ($file) {
            return Storage::cloud()->url($file ?? '-');
        });
        return static::getTransactionResult();
    }

    public static function uploadToCloud(string $folder, $file): string | null | bool
    {
        static::safeBlock(function () use ($folder, $file) {
            return Storage::disk('s3')->put($folder, $file);
        });
        return static::getTransactionResult();
    }


    ///// Exception handlers //////
    public static function safeTransaction(Closure $closure): bool
    {
        DB::beginTransaction();
        try {
            static::$transactionResult = $closure();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            static::$transactionResult = $e;
            return false;
        }
        return true;
    }


    public static function getTransactionResult()
    {
        return static::$transactionResult;
    }

    public static function safeBlock(Closure $closure): bool
    {
        try {
            static::$transactionResult = $closure();
        } catch (\Exception $e) {
            static::$transactionResult = $e;
            return false;
        }
        return true;
    }

    public static function ApiRequest(string $url, array $query = [])
    {
        Helper::safeBlock(function () use ($url, $query) {
            return Helper::getApiResult($url, $query);
        });
        return Helper::getTransactionResult();
    }

    public static function getApiResult(string $url, array $query = [], array $customOptions = [], string $type = 'get')
    {
        $client   = new Client(['base_uri' => Helper::getApiHost()]);
        $response = $client->{$type}($url, !empty($customOptions) ? $customOptions : array(
            // RequestOptions::HEADERS => ['Authorization' => 'Bearer ' . Helper::getApiToken()],
            RequestOptions::QUERY   => $query
        ), ['Content-Type' => 'application/json']);
        return json_decode($response->getBody(), true);
    }

    

    ////// deprecated methods //////
    public static function globalUploadFile($file, $destinationPath)
    {
        $image    = $file;
        $orgName  = $file->getClientOriginalName();
        $fileName = pathinfo($orgName); // get original file name without ext 
        $fileName = $fileName['filename'] . '_' . time() . '.' . $image->extension();
        $image->move($destinationPath, $fileName);
        return $fileName;
    }
}
