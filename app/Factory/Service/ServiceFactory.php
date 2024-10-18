<?php

namespace App\Factory\Service;

use App\Factory\Business\FaqFactory;
use App\Factory\Factory;
use App\Helpers\Helper;
use App\Models\Package\PackageService;
use App\Models\Service\Service;
use App\Models\Service\ServiceFestival;
use App\Models\Service\ServiceImage;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(Service::with('category', 'sub_category', 'sub_sub_category')->orderBy('created_at', 'desc')->get())->addIndexColumn()
            ->editColumn('status', function ($type) {
                $checked = empty($type->status) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.service.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('image', function ($row) {
                return '<img src="' . $row->image . '" alt="" height="45px">';
            })
            ->editColumn('show_on_home_page', function ($type) {
                $checked = empty($type->show_on_home_page) ? '' : 'checked';
                // return $checked;
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-type="show_on_home_page" data-target=' . route('admin.service.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('category', function ($row) {
                return empty($row->category->title) ? '' : $row->category->title;
            })
            ->editColumn('sub_category', function ($row) {
                return empty($row->sub_category->title) ? '' : $row->sub_category->title;
            })
            ->editColumn('sub_sub_category', function ($row) {
                return empty($row->sub_sub_category->title) ? '' : $row->sub_sub_category->title;
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
                $html  = '<a href="' . route('admin.service.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.service.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'status', 'summary', 'image', 'show_on_home_page'])
            ->make(true);
    }

    public static function create($model, $data){
        parent::create($model, $data);
        $instance = Helper::getTransactionResult();
        static::mapItems(ServiceImage::class, 'service_id',  $instance, 'url', $data['images'] ?? []);
        static::mapItems(ServiceFestival::class, 'service_id',  $instance, 'festival_id', $data['festivals'] ?? []);
        static::mapItems(PackageService::class, 'service_id',  $instance, 'package_id', $data['packages'] ?? []);
        FaqFactory::addOrUpdate($data['faq_question'] ?? [], $data['faq_answer'] ?? [], 'service_id', $instance->id);
    }

    public static function update(&$instance, $data){
        parent::update($instance, $data);
        static::mapItems(ServiceImage::class, 'service_id',  $instance, 'url', $data['images'] ?? []);
        static::mapItems(ServiceFestival::class, 'service_id',  $instance, 'festival_id', $data['festivals'] ?? []);
        static::mapItems(PackageService::class, 'service_id',  $instance, 'package_id', $data['packages'] ?? []);
        FaqFactory::addOrUpdate($data['faq_question'] ?? [], $data['faq_answer'] ?? [], 'service_id', $instance->id);
    }
}
