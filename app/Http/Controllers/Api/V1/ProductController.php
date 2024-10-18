<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Business\Category;
use App\Models\Business\Gift;
use App\Models\Business\SubCategory;
use App\Models\Business\SubSubCategory;
use App\Models\Business\Type;
use App\Models\Package\Package;
use App\Models\Package\PackageProduct;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('product:read'))  return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);

        self::query(Product::with(relations: static::relations())->select(...static::fields()));

        self::filter();

        self::sort();

        self::addExtraFields();

        return self::response(self::result());
    }

    public static function fields()
    {
        return ['id', 'title', 'price', 'old_price', 'gift_type_id', 'meta_title', 'min_order_qty', 'terms_and_conditions', 'meta_keywords', 'meta_descriptions', 'slug', 'category_id', 'description', 'summary', 'product_detail', 'delivery_info', 'cancellation_policy', 'sub_category_id', 'sub_sub_category_1_id as sub_sub_category_id', 'image', 'price_onwards'];
    }

    public static function relations()
    {
        return array('category' => function ($q) {
            return $q->select('title', 'slug', 'id');
        },  'sub_category' => function ($q) {
            return $q->select('title', 'id');
        }, 'sub_sub_category_1' => function ($q) {
            return $q->select('title', 'id');
        }, 'images' => function ($q) {
            return $q->select('url', 'product_id');
        });
    }

    public static function filter()
    {
        self::query()->where('status', Helper::STATUS_ACTIVE);

        if (!empty(request()->except))      self::query()->whereNot('id', request()->except);
        if (!empty(request()->category_id)) self::query()->where('category_id', (int) request()->category_id);

        if (!empty(request()->category)) {
            self::set('business_type', Type::select('id', 'title', 'description', 'slug')->where('slug', 'LIKE', '%product%')->first());
            self::set('category', Category::select('id', 'title', 'slug', 'description')->where('slug', request()->category)->where('business_type', self::get('business_type')->id)->first());
            self::set('sub_category', SubCategory::select('id', 'title', 'slug')->where('category_id', self::get('category')->id ?? 0)->get());
            self::set('sub_sub_category', SubSubCategory::select('id', 'title', 'slug', 'sub_category_id')->whereIn('sub_category_id', array_map(function($category){ return $category['id']; }, self::get('sub_category')->toArray() ))->get());
            

            self::query()->where('category_id', self::get('category')->id ?? 0);
        }

        if (!empty(request()->category_like)) {
            $categoryIds  = Category::select('id', 'title', 'slug', 'description')->where('title', 'like', '%' .  request()->category_like . '%')->pluck('id');
            self::query()->whereIn('category_id', $categoryIds);
        }

        if (!empty(request()->package)) {
            self::set('package', Package::select('id')->where('id', request()->package)->first());
            $packageProducts = PackageProduct::where('package_id', self::get('package')->id)->pluck('product_id');
            self::query()->whereIn('id', $packageProducts);
        }

        if (!empty(request()->gift)) {
            self::set('gift', Gift::select('id', 'title', 'description')->where('status', Helper::STATUS_ACTIVE)->get());
            $ids = [];
            foreach (self::get('gift') as  $gift) $ids[] = $gift->id;
            self::query()->whereIn('gift_type_id', $ids);
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

        if (!empty(request()->gift)) 
            $instance['gift_type'] = self::get('gift');

        if (!empty(request()->package)) 
            $instance['package']  = self::get('package');

        self::set('extra_fields', $instance);
    }

    public static function result()
    {
        return self::query()->get()->map(function ($row) {
            $row->sub_sub_category = $row->sub_sub_category_1;
            $images = collect($row->images)->map(function ($img) {
                return $img->url;
            });
            unset($row->category_id, $row->images, $row->sub_category_id, $row->sub_sub_category_1_id, $row->sub_sub_category_1);
            $row->images = $images;
            $row->uri = '/product/' . @$row->category->slug . '/' . $row->slug;
            return $row;
        });   
    }

    public function detail($slug)
    {
        $product = Product::with(static::relations())->select(...static::fields())->where('slug', $slug)->first();

        if (empty($product)) return response()->json(array(
            'status' => false,
        ), 200);

        $imgs = $product->images;
        unset($product->images);
        $product->images =  collect($imgs)->map(function ($img) {
            return $img->url;
        });

        return self::response($product);
    }
}
