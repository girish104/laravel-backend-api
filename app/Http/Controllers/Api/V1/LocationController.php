<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\Business\Location;
use Illuminate\Http\Request;

class LocationController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('location:read'))  return self::error('Unauthorised.', ['error'=>'Unauthorised']);
        
        self::query(Location::select(...static::fields()));

        self::filter();
        
        self::sort();

        return self::response(self::result());
    }

    public static function fields()
    {
        return ['id', 'name', 'is_default'];
    }

    public static function sort()
    {
        static::query()->orderBy('created_at', 'desc');
    }
}
