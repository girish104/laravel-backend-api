<?php

namespace App\Factory\Package;

use App\Factory\Factory;
use App\Helpers\Helper;
use App\Models\Package\Package;
use App\Models\Package\PackageFestival;
use App\Models\Package\PackageImage;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class PackageFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(Package::orderBy('created_at', 'desc')->get())->addIndexColumn()
            ->editColumn('status', function ($type) {
                $checked = empty($type->status) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.package.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('is_popular', function ($type) {
                $checked = empty($type->is_popular) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-type="is_popular" data-target=' . route('admin.package.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('image', function ($row) {
                return '<img src="' . $row->image . '" alt="" height="45px">';
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
                $html  = '<a href="' . route('admin.package.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.package.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'status', 'summary', 'image', 'is_popular'])
            ->make(true);
    }

    public static function create($model, $data){
        parent::create($model, $data);
        $instance = Helper::getTransactionResult();
        static::mapItems(PackageImage::class, 'package_id',  $instance, 'url', $data['images'] ?? []);
        static::mapItems(PackageFestival::class, 'package_id',  $instance, 'festival_id', $data['festivals'] ?? []);
    }

    public static function update(&$instance, $data){
        parent::update($instance, $data);
        static::mapItems(PackageImage::class, 'package_id',  $instance, 'url', $data['images'] ?? []);
        static::mapItems(PackageFestival::class, 'package_id',  $instance, 'festival_id', $data['festivals'] ?? []);
    }
}
