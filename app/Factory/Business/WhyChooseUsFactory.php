<?php

namespace App\Factory\Business;

use App\Factory\Factory;
use App\Models\Business\WhyChooseUs;
use Illuminate\Support\Str;

class WhyChooseUsFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(WhyChooseUs::orderBy('created_at', 'desc')->get())->addIndexColumn()
            ->editColumn('status', function ($row) {
                $checked = empty($row->status) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.why-choose-us.toggle-status', $row->id) . ' data-id="' . $row->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('image', function ($row) {
                return '<img src="' . $row->image . '" alt="" height="45px">';
            })
            ->editColumn('description', function ($row) {
                return Str::limit($row->summary, 100);
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->editColumn('type', function ($row) {
                return empty($row->row->title) ? '' : $row->row->title;
            })
            ->editColumn('action', function ($row) {
                $html  = '<a href="' . route('admin.why-choose-us.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.why-choose-us.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'status', 'image'])
            ->make(true);
    }
}
