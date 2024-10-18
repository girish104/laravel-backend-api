<?php

namespace App\Factory\Business;

use App\Factory\Factory;
use App\Models\Business\Gift;
use App\Models\Business\Type;

class GiftFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(Gift::orderBy('created_at')->get())->addIndexColumn()
            ->editColumn('status', function ($type) {
                $checked = empty($type->status) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.gift.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('created_at', function ($type) {
                return $type->created_at->format('Y-m-d');
            })
            ->editColumn('action', function ($row) {
                $html  = '<a href="' . route('admin.gift.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.gift.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
