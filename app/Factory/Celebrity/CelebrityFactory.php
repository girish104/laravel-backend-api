<?php

namespace App\Factory\Celebrity;

use App\Factory\Factory;
use App\Helpers\Helper;
use App\Models\Celebrity;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class CelebrityFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(Celebrity::with('category', 'sub_category')->orderBy('created_at', 'desc')->get())->addIndexColumn()
            ->editColumn('status', function ($type) {
                $checked = empty($type->status) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.celebrity.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('is_popular', function ($type) {
                $checked = empty($type->is_popular) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-type="is_popular" data-target=' . route('admin.celebrity.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
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
                $html  = '<a href="' . route('admin.celebrity.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.celebrity.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'status', 'summary', 'image', 'is_popular'])
            ->make(true);
    }
}
