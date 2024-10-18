<?php

namespace App\Factory\Product;

use App\Factory\Business\FaqFactory;
use App\Factory\Factory;
use App\Helpers\Helper;
use App\Models\Business\Faq;
use App\Models\Package\PackageProduct;
use App\Models\Product;
use App\Models\Product\ProductFestival;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(Product::with('category', 'sub_category', 'sub_sub_category_1')->orderBy('created_at', 'desc')->get())->addIndexColumn()
            ->editColumn('status', function ($type) {
                $checked = empty($type->status) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.product.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('image', function ($row) {
                return '<img src="' . $row->image . '" alt="" height="45px">';
            })
            ->editColumn('category', function ($row) {
                return empty($row->category->title) ? '' : $row->category->title;
            })
            ->editColumn('sub_category', function ($row) {
                return empty($row->sub_category->title) ? '' : $row->sub_category->title;
            })
            ->editColumn('sub_sub_category_1', function ($row) {
                return empty($row->sub_sub_category_1->title) ? '' : $row->sub_sub_category_1->title;
            })
            ->editColumn('summary', function ($row) {
                return Str::limit($row->summary, 100);
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->editColumn('type', function ($row) {
                return empty($row->type->title) ? '' : $row->type->title;
            })
            ->editColumn('action', function ($row) {
                $html  = '<a href="' . route('admin.product.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.product.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'status', 'summary', 'image'])
            ->make(true);
    }

    public static function create($model, $data){
        parent::create($model, $data);
        $instance = Helper::getTransactionResult();
        static::mapItems(ProductImage::class, 'product_id',  $instance, 'url', $data['images'] ?? []);
        static::mapItems(ProductFestival::class, 'product_id',  $instance, 'festival_id', $data['festivals'] ?? []);
        static::mapItems(PackageProduct::class, 'product_id',  $instance, 'package_id', $data['packages'] ?? []);
        FaqFactory::addOrUpdate($data['faq_question'] ?? [], $data['faq_answer'] ?? [], 'product_id', $instance->id);
    }

    public static function update(&$instance, $data){
        parent::update($instance, $data);
        static::mapItems(ProductImage::class, 'product_id',  $instance, 'url', $data['images'] ?? []);
        static::mapItems(ProductFestival::class, 'product_id',  $instance, 'festival_id', $data['festivals'] ?? []);
        static::mapItems(PackageProduct::class, 'product_id',  $instance, 'package_id', $data['packages'] ?? []);
        FaqFactory::addOrUpdate($data['faq_question'] ?? [], $data['faq_answer'] ?? [], 'product_id', $instance->id);
    }    
}
