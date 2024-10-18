<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Models\Business\Category;
use App\Models\Business\SubCategory;
use App\Models\Business\Type;
use App\Models\Celebrity;
use App\Models\Package\Package;
use App\Models\Product;
use App\Models\Service\Service;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('cart:read'))  return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        $result = [];
        // return self::response($request->items);

        $totalPrice = 0;
        foreach ($request->items ?? [] as $item) {
            $detail = 0;
            if ($item["type"] == "product") {
                $detail         = Product::with('category')->where('id', $item['item_id'])->first();
                $item['detail'] = array(
                    'title'     => $detail->title,
                    'summary'   => $detail->description,
                    'price'     => $detail->price,
                    'image'     => $detail->image,
                    'category'  => @$detail->category->title ?? '',
                    'uri'       => '/product/' . @$detail->category->slug . '/' . @$detail->slug
                );
            } else if ($item["type"] == "service") {
                $detail         = Service::with('category')->where('id', $item['item_id'])->first();
                $item['detail'] = array(
                    'title'     => $detail->title,
                    'summary'   => $detail->description,
                    'price'     => $detail->price,
                    'image'     => $detail->image,
                    'category'  => @$detail->category->title ?? '',
                    'uri'       => '/service/' . @$detail->category->slug . '/' . @$detail->slug
                );
            } else if ($item["type"] == "package") {
                $detail         = Package::with('category')->where('id', $item['item_id'])->first();
                $item['detail'] = array(
                    'title'     => $detail->title,
                    'summary'   => $detail->summary,
                    'price'     => $detail->price,
                    'image'     => $detail->image,
                    'category'  => 'Package',
                    'uri'       => '/package/' . @$detail->category->slug . '/' . @$detail->slug
                );
            } else if ($item["type"] == "celebrity") {
                $detail         = Celebrity::with('category')->where('id', $item['item_id'])->first();
                $item['detail'] = array(
                    'title'     => $detail->name,
                    'summary'   => $detail->description,
                    'price'     => $detail->price,
                    'image'     => $detail->image,
                    'category'  => @$detail->category->title ?? '',
                    'uri'       => '/celebrity/' . @$detail->category->slug . '/' . @$detail->slug
                );
            }

            $item['total_price'] = ((double)$item['qty']) * ((double)$detail->price);
            $item['price'] = $detail->price;
            $result[]      = $item;
            $totalPrice   += $item['total_price'];
        }

        return self::response(['total_price' => $totalPrice, 'items' =>  $result]);
    }
}
