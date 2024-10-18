<?php

namespace App\Factory\Business;

use App\Factory\Factory;
use App\Models\Business\SubCategory;

class SubCategoryFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(SubCategory::with('type', 'category')->orderBy('created_at', 'desc')->get())->addIndexColumn()
            ->editColumn('status', function (SubCategory $type) {
                $checked = empty($type->status) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.sub-category.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('created_at', function (SubCategory $row) {
                return $row->created_at->format('Y-m-d');
            })
            ->editColumn('category', function (SubCategory $row) {
                return empty($row->category->title) ? '' : $row->category->title;
            })
            ->editColumn('type', function (SubCategory $row) {
                return empty($row->type->title) ? '' : $row->type->title;
            })
            ->editColumn('action', function (SubCategory $row) {
                $html  = '<a href="' . route('admin.sub-category.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.sub-category.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
