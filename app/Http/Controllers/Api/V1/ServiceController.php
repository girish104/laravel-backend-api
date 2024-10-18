<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Business\Category;
use App\Models\Business\SubCategory;
use App\Models\Business\SubSubCategory;
use App\Models\Business\Type;
use App\Models\Service\Service;
use Illuminate\Support\Collection;


use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('service:read'))  return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        self::query(Service::with(static::relations())->select(...static::fields()));
        self::filter();
        self::sort();
        self::addExtraFields();
        return self::response(self::result());
    }

    public static function fields()
    {
        return ['id', 'title', 'price', 'old_price', 'icon', 'price_onwards', 'show_on_home_page', 'col_width', 'rating', 'reviews', 'meta_title', 'meta_keywords', 'meta_descriptions', 'slug', 'category_id', 'description', 'summary', 'service_detail', 'delivery_info', 'cancellation_policy', 'sub_category_id', 'sub_sub_category_id', 'image'];
    }

    public static function sort()
    {
        static::query()->orderBy('position');
    }

    public static function relations()
    {
        return array('category' => function ($q) {
            return $q->select('title', 'slug', 'id');
        },  'sub_category' => function ($q) {
            return $q->select('title', 'id');
        }, 'images' => function ($q) {
            return $q->select('url', 'service_id');
        });
    }

    public static function filter()
    {
        parent::filter();
        if (!empty(request()->category)) {
            self::set('business_type', Type::select('id', 'title', 'description', 'slug')->where('slug', 'LIKE', '%service%')->first());
            self::set('category', Category::select('id', 'title', 'slug', 'description')->where('slug', request()->category)->where('business_type', self::get('business_type')->id)->first());
            self::set('sub_category', SubCategory::select('id', 'title', 'slug')->where('category_id', self::get('category')->id ?? 0)->get());
            self::set('sub_sub_category', SubSubCategory::select('id', 'title', 'slug', 'sub_category_id')->whereIn('sub_category_id', array_map(function($category){ return $category['id']; }, self::get('sub_category')->toArray() ))->get());
            
            // Service::update([]);

            self::query()->where('category_id', self::get('category')->id ?? 0);
        }
    }

    public static function addExtraFields()
    {
        $instance = [];
        
        if (!empty(request()->category)) {
            $instance['business_type'] = self::get('business_type');
            $instance['category']      = self::get('category');
            $instance['sub_category']  = self::get('sub_category');
            $instance['sub_sub_category'] = self::get('sub_sub_category');
        }

        self::set('extra_fields', $instance);
    }

    public static function result()
    {
       return self::query()->get()->map(function ($row) {
            $images = collect($row->images)->map(function ($img) {
                return $img->url;
            });
            unset($row->category_id, $row->images, $row->sub_category_id);
            $row->images = $images;
            $row->uri = '/service/' . @$row->category->slug . '/' . $row->slug;
            return $row;
        });   
    }

    public function detail($slug)
    {
        $service = Service::with(static::relations())->select(...static::fields())->where('slug', $slug)->first();

        if (empty($service)) return response()->json(array(
            'status' => false,
        ), 200);
        
        $imgs = $service->images;
        unset($service->images);
        $service->images =  collect($imgs)->map(function ($img) {
            return $img->url;
        });

        return self::response($service);
    }
}
