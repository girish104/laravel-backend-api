<?php

namespace App\Factory\Business;

use App\Factory\Factory;
use App\Models\Business\SubCategory;
use App\Models\Business\SubSubCategory;

class SubSubCategoryFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(SubSubCategory::with('businesstype', 'category', 'sub_category')->orderBy('created_at', 'desc')->get())->addIndexColumn()
            ->editColumn('status', function ($type) {
                $checked = empty($type->status) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.sub-sub-category.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->editColumn('category', function ($row) {
                return empty($row->category->title) ? '' : $row->category->title;
            })
            ->editColumn('sub_category', function ($row) {
                return empty($row->sub_category->title) ? '' : $row->sub_category->title;
            })
            ->editColumn('category_type', function ($row) {
                return $row->type;
            })
            ->editColumn('business_type', function ($row) {
                return empty($row->businesstype->title) ? '' : $row->businesstype->title;
            })
            ->editColumn('action', function ($row) {
                $html  = '<a href="' . route('admin.sub-sub-category.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.sub-sub-category.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public static function create($model, $data)
    {
        // if (!in_array($data['type'], range(1, 6))) return false;
        $dataToBeCreated      =  array(
            'title'           => $data['title'] ?? '',
            'description'     => $data['description'] ?? '',
            'status'          => $data['status'] ?? 0,
            'type'            => $data['type'] ?? 1,
            'business_type'   => $data['business_type'] ?? 0,
            'category_id'     => $data['category_id'] ?? 0,
            'sub_category_id' => $data['sub_category_id'] ?? 0,
        );

        // if ($data['type'] > 1) $dataToBeCreated['sub_sub_category_1_id'] = $data['sub_sub_category_1_id'];
        // if ($data['type'] > 2) $dataToBeCreated['sub_sub_category_2_id'] = $data['sub_sub_category_2_id'];
        // if ($data['type'] > 3) $dataToBeCreated['sub_sub_category_3_id'] = $data['sub_sub_category_3_id'];
        // if ($data['type'] > 4) $dataToBeCreated['sub_sub_category_4_id'] = $data['sub_sub_category_4_id'];
        // if ($data['type'] > 5) $dataToBeCreated['sub_sub_category_5_id'] = $data['sub_sub_category_5_id'];

        return parent::create($model, $dataToBeCreated);
    }
}
