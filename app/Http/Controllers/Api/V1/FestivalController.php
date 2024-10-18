<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Business\Festival;
use App\Models\Package\PackageFestival;
use App\Models\Product;

use Illuminate\Http\Request;

class FestivalController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('festival:read'))  return self::error('Unauthorised.', ['error'=>'Unauthorised']);
        self::query(Festival::select(...static::fields()));
        self::filter();
        self::sort();
        self::addExtraFields();
        return self::response(self::result());
    }

    public static function fields()
    {
        return ['id', 'title', 'image', 'description', 'slug'];
    }

    public static function sort()
    {
        static::query()->orderBy('position');
    }

    public static function addExtraFields()
    {
        $instance = [];
        if (!empty(request()->category)) {
            $instance['business_type'] = self::get('business_type');
            $instance['category']      = self::get('category');
        }
        self::set('extra_fields', $instance);
    }

    public function detail($slug)
    {
        $festival = Festival::with('package.package', 'package.package.category', 'product.product',  'product.product.category',  'service.service', 'service.service.category')
            ->select('id', 'title', 'description', 'slug')->where('slug', $slug)->first();

        if (empty($festival)) return self::error('Festival not found');

        $festival->product->map(function ($row) {
            $row->title       = @$row->product->title;
            $row->image       = @$row->product->image_original;
            $row->description = @$row->product->description;
            $row->price       = @$row->product->price;
            $row->old_price   = @$row->product->old_price;
            $row->uri        = '/product/' . @$row->product->category->slug . '/' . @$row->product->slug;
            unset($row->id, $row->festival_id, $row->product_id, $row->position, $row->created_at, $row->updated_at, $row->product);
            return $row;
        });

        $festival->service->map(function ($row) {
            $row->title       = @$row->service->title;
            $row->image       = @$row->service->image_original;
            $row->description = @$row->service->description;
            $row->price       = @$row->service->price;
            $row->old_price   = @$row->service->old_price;
            $row->uri        = '/service/' . @$row->service->category->slug . '/' . @$row->service->slug;
            unset($row->id, $row->festival_id, $row->service_id, $row->position, $row->created_at, $row->updated_at, $row->service);
            return $row;
        });

        $festival->package->map(function ($row) {
            $row->title       = @$row->package->title;
            $row->image       = @$row->package->image_original;
            $row->description = @$row->package->description;
            $row->price       = @$row->package->price;
            $row->old_price   = @$row->package->old_price;
            $row->uri        = '/package/' . @$row->package->category->slug . '/' . @$row->package->slug;
            unset($row->id, $row->festival_id, $row->package_id, $row->position, $row->created_at, $row->updated_at, $row->package);
            return $row;
        });

        return self::response($festival);
    }


    public static function getFirstResult()
    {
        // return self::query()->first()->map(function ($row) {
        //     $row->sub_sub_category = $row->sub_sub_category_1;
        //     $images = collect($row->images)->map(function ($img) {
        //         return $img->url;
        //     });
        //     unset($row->category_id, $row->images, $row->sub_category_id, $row->sub_sub_category_1_id, $row->sub_sub_category_1);
        //     $row->images = $images;
        //     $row->uri = '/product/' . @$row->category->slug . '/' . $row->slug;
        //     return $row;
        // });   
    }
}
