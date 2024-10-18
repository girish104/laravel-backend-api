<?php

namespace App\Factory\Business;

use App\Factory\Factory;
use App\Models\Business\Category;

class CategoryFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(Category::with('type')->orderBy('created_at', 'desc')->get())->addIndexColumn()
            ->editColumn('status', function (Category $type) {
                $checked = empty($type->status) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.category.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('show_on_home_page', function ($type) {
                $checked = empty($type->show_on_home_page) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-type="show_on_home_page" data-target=' . route('admin.event.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('created_at', function (Category $row) {
                return $row->created_at->format('Y-m-d');
            })
            ->editColumn('type', function (Category $row) {
                return empty($row->type->title) ? '' : $row->type->title;
            })
            ->editColumn('action', function (Category $row) {
                $html  = '<a href="' . route('admin.category.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.category.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'status', 'show_on_home_page'])
            ->make(true);
    }
}
