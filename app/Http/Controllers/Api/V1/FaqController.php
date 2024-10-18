<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\Business\Faq;
use Illuminate\Http\Request;

class FaqController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('faq:read'))  return self::error('Unauthorised.', ['error'=>'Unauthorised']);
        
        self::query(Faq::select(...static::fields()));

        self::filter();
        
        self::sort();

        return self::response(self::result());
    }

    public static function fields()
    {
        return ['id', 'question', 'answer'];
    }

    public static function sort()
    {
        if (!empty(request()->product) || !empty(request()->service)) {
            static::query()->orderBy('position', 'asc');
            return;
        } 

        static::query()->orderBy('created_at', 'desc');
    }

    public static function filter()
    {
        parent::filter();

        if (empty(request()->product) && empty(request()->service))
            self::query()->whereNull('service_id')->whereNull('product_id');

        if (!empty(request()->product))
            self::query()->where('product_id', request()->product);

        if (!empty(request()->service))
            self::query()->where('service_id', request()->service);
    }
}
