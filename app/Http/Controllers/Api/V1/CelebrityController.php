<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Business\Category;
use App\Models\Business\SubCategory;
use App\Models\Business\Type;
use App\Models\Celebrity;


use Illuminate\Http\Request;

class CelebrityController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('celebrity:read'))  return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);

        self::query(Celebrity::with(static::relations())->select(...static::fields()));
        self::filter();
        self::sort();
        self::addExtraFields();

        return self::response(self::result());
    }

    public static function fields()
    {
        return ['id', 'name', 'category_id', 'sub_category_id', 'image', 'price', 'old_price', 'slug', 'summary', 'price_onwards'];
    }

    public static function filter()
    {
        parent::filter();
        if (!empty(request()->popular)):
            self::query()->where('is_popular', Helper::STATUS_ACTIVE);
        endif;

        if (!empty(request()->category)):
            self::set('business_type', Type::select('id', 'title', 'description', 'slug')->where('slug', 'LIKE', '%celebr%')->first());
            self::set('category', Category::select('id', 'title', 'slug', 'description')->where('slug', request()->category)->where('business_type', self::get('business_type')->id)->first());
            self::set('sub_category', SubCategory::select('id', 'title', 'slug')->where('category_id', self::get('category')->id ?? 0)->get());
            self::query()->where('category_id', self::get('category')->id ?? 0);
        endif;
    }

    public static function addExtraFields()
    {
        $instance = [];

        if (!empty(request()->category)) :
            $instance['business_type'] = self::get('business_type');
            $instance['category']      = self::get('category');
            $instance['sub_category']  = self::get('sub_category');
        endif;

        if (!empty(request()->gift)) :
            $instance['gift_type'] = self::get('gift');
        endif;

        self::set('extra_fields', $instance);
    }

    public static function relations()
    {
        return array('category' => function ($q) {
            return $q->select('title', 'id', 'slug');
        },  'sub_category' => function ($q) {
            return $q->select('title', 'id', 'slug');
        });
    }

    public static function result()
    {
        return self::query()->get()->map(function ($row) {
            $row->uri = '/celebrity/' . @$row->category->slug . '/' . $row->slug;
            return $row;
        });   
    }

    public function detail($slug)
    {
        self::query(Celebrity::with(static::relations())->select(...static::fields(), ...['celebrity_detail', 'rating', 'description']));

        self::filter();
        
        $celebrity = self::query()->where('slug', $slug)->first();

        if (empty($celebrity)) self::error('Celebrity not found');

        return self::response($celebrity);
    }
}
