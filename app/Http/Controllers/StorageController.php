<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class StorageController
{
    private const  UPLOAD_DISK      = 'public';
    private const  STORAGE_LOCATION = 's3'; // local | s3 
    private static $uploadedFiles   = NULL;

    public function upload(Request $request, $type)
    {
        $file = $request->file('file');
        empty($request->multiple) ? static::uploadSingleFile($type, $file) : static::uploadMultipleFiles($type, $file);
        return static::response();
    }

    private static function uploadMultipleFiles($type, &$files)
    {
        if (is_array($files)) foreach ($files as $file)
             static::$uploadedFiles[] = static::uploadFile($type, $file, static::UPLOAD_DISK);
        else static::$uploadedFiles[] = static::uploadFile($type, $files, static::UPLOAD_DISK);
    }

    private static function uploadSingleFile($type, &$files)
    {
        static::$uploadedFiles = static::uploadFile($type, $files);
    }

    private static function response()
    {
        return response(array(
            'status' => true,
            'url'    => static::$uploadedFiles
        ), Response::HTTP_ACCEPTED);
    }

    private static function uploadFile($type, $file, $disk = self::UPLOAD_DISK){
        if (static::STORAGE_LOCATION === Helper::STORAGE_LOCATION_CLOUD) 
            return static::uploadToCloud($type, $file);
        
        return static::uploadToLocal($type, $file, $disk);
    }


    // public static function fileUrl(string | null | bool $file): string | bool
    // {
    //     Helper::safeBlock(function () use ($file) {
    //         return Storage::cloud()->url($file ?? '-');
    //     });
    //     return Helper::getTransactionResult();
    // }
    
    public static function uploadToCloud(string $folder, $file): string | null | bool
    {
        Helper::safeBlock(function () use ($folder, $file) {
            return Storage::disk('s3')->put($folder, $file);
        });
        return Helper::getTransactionResult();
    }

    public static function uploadToLocal(string $path,  $file, $disk = 'public')
    {
        Helper::safeBlock(function () use ($path, $file, $disk) {
            return '/storage/' . Storage::disk($disk)->put($path, $file);
        });
        return Helper::getTransactionResult();
    }

}
