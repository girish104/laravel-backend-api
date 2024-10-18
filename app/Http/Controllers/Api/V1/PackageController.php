<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Package\Package;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Business\Category;
use App\Models\Business\SubCategory;
use App\Models\Business\Type;


class PackageController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('package:read'))  return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);

        self::query(Package::with(static::relations())->select(...static::fields()));

        self::set('business_type', Type::select('id', 'title', 'description', 'slug')->where('slug', 'LIKE', '%package%')->first());
        self::set('category', Category::select('id', 'title', 'slug', 'description')->where('business_type', self::get('business_type')->id)->first());

        self::filter();

        self::sort();

        self::addExtraFields();

        return self::response(self::result());
    }

    public static function fields()
    {
        return ['id', 'title', 'price', 'old_price', 'price_onwards', 'meta_title', 'meta_keywords', 'meta_descriptions', 'slug', 'description', 'summary', 'detail', 'cancellation_policy', 'image', 'category_id','sub_category_id', 'business_type_id'];
    }

    public static function addExtraFields()
    {
        $instance = [];
        $instance['business_type'] =  Type::select('id', 'title', 'description', 'slug')->where('slug', 'LIKE', '%package%')->first();
        $instance['category']      = Category::select('id', 'title', 'slug', 'description')->where('business_type', self::get('business_type')->id)->get();

        if (!empty(request()->category)) {
            $instance['selected_category'] = Category::select('id', 'title', 'slug', 'description')->where('slug', request()->category)->where('business_type', @$instance['business_type']->id)->first();
        }

        self::set('extra_fields', $instance);
    }

    public static function relations()
    {
        return array(
            'images' => function ($q) {
                return $q->select('url', 'package_id');
            },
            'service' => function ($q) {
                return $q->with('service', 'service.category')->select('service_id', 'package_id');
            },
            'product' => function ($q) {
                return $q->with('product', 'product.category')->select('product_id', 'package_id');
            },
            'category' => function ($q) {
                return $q->select('title', 'slug', 'id');
            },
            'sub_category' => function ($q) {
                return $q->select('title', 'id');
            },
        );
    }



    public static function filter()
    {
     
        self::query()->where('status', Helper::STATUS_ACTIVE);

        if (!empty(request()->popular))
            self::query()->where('is_popular', Helper::STATUS_ACTIVE);

        self::query()->whereNot('id', request()->except);

        if (!empty(request()->category_id))
            self::query()->where('category_id', (int) request()->category_id);

        if (!empty(request()->category)) {
            self::set('business_type', Type::select('id', 'title', 'description', 'slug')->where('slug', 'LIKE', '%package%')->first());
            self::set('category',     Category::select('id', 'title', 'slug', 'description')->where('slug', request()->category)->where('business_type', self::get('business_type')->id)->first());
            self::set('sub_category', SubCategory::select('id', 'title', 'slug')->where('category_id', self::get('category')->id ?? 0)->get());


            self::query()->where('category_id', self::get('category')->id ?? 0);
        }

    }

    public static function result()
    {
        return self::query()->get()->map(function ($row) {

            static::alterColumns($row);

            return $row;
        });
    }


    public function detail($slug)
    {
        $package = Package::with(static::relations())->select(...static::fields())->where('slug', $slug)->first();

        if (empty($package))
            return response()->json(
                array(
                    'status' => false,
                ), 200);

        static::alterColumns($package);

        return response()->json(
            array(
                'status' => true,
                'data' => $package
            ), 200);
    }


    public static function alterColumns(&$package)
    {
        $package->uri = '/package/' . @$package->category->slug . '/' .  $package->slug;

        $imgs = $package->images;
        unset($package->images);
        $package->images = collect($imgs)->map(function ($img) {
            return $img->url;
        });

        if (!empty($package->service)) {
            $services = collect($package->service)->map(function ($service) {
                if (empty($service->service))
                    return;
                $service = $service->service;
                return array(
                    "id" => $service->id,
                    "title" => $service->title,
                    "image" => $service->image,
                    "summary" => $service->summary,
                    "tags" => $service->tags,
                    "detail" => $service->service_detail,
                    "price" => $service->price,
                    "old_price" => $service->old_price,
                    "uri" => '/service/' . @$service->category->slug . '/' . $service->slug
                );
            })->filter()->toArray();
            unset($package->service);
            $package->service = $services;
        }

        if (!empty($package->product)) {
            $products = collect($package->product)->map(function ($product) {
                if (empty($product->product))
                    return;
                $product = $product->product;
                return array(
                    "id" => $product->id,
                    "title" => $product->title,
                    "image" => $product->image,
                    "summary" => $product->summary,
                    "tags" => $product->tags,
                    "detail" => $product->product_detail,
                    "price" => $product->price,
                    "old_price" => $product->old_price,
                    "uri" => '/product/' . @$product->category->slug . '/' . $product->slug
                );
            })->filter()->toArray();
            unset($package->product);
            $package->product = $products;
        }
    }
}