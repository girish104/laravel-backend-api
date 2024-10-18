<?php

namespace App\Factory\Business;

use App\Factory\Factory;
use App\Models\Business\Location;


class LocationFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(Location::orderBy('created_at', 'desc')->get())->addIndexColumn()
            ->editColumn('status', function ($row) {
                $checked = empty($row->status) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.location.toggle-status', $row->id) . ' data-id="' . $row->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('is_default', function ($row) {
                $checked = empty($row->is_default) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-type="is_default" data-target=' . route('admin.location.toggle-status', $row->id) . ' data-id="' . $row->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->editColumn('action', function ($row) {
                $html  = '<a href="' . route('admin.location.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.location.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'status', 'is_default'])
            ->make(true);
    }
}
