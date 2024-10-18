<?php

namespace App\Factory\Business;

use App\Factory\Factory;
use App\Helpers\Helper;
use App\Models\Business\Faq;
use Illuminate\Support\Str;

class FaqFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(Faq::orderBy('created_at', 'desc')->get())->addIndexColumn()
            ->editColumn('status', function ($row) {
                $checked = empty($row->status) ? '' : 'checked';
                $html  =  '<label class="switch">';
                $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.faq.toggle-status', $row->id) . ' data-id="' . $row->id . '" ' . $checked . ' >';
                $html .=  '<span class="slider round"></span>';
                $html .=  '</label>';
                return $html;
            })
            ->editColumn('question', function ($row) {
                return Str::limit($row->question, 100);
            })
            ->editColumn('answer', function ($row) {
                return Str::limit($row->answer, 100);
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->editColumn('action', function ($row) {
                $html  = '<a href="' . route('admin.faq.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.faq.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'status', 'image'])
            ->make(true);
    }


    public static function addOrUpdate($questions, $answers, $column, $columnId){
        $position       = 0;
        $savedPositions = [];
        foreach ($questions as $key => $question) {
            $position++;
            Faq::updateOrCreate(
                [$column       => $columnId, 'position' => $position],
                [
                    'question' => $question,
                    'answer'   => $answers[$key] ?? '',
                    'status'   => Helper::STATUS_ACTIVE,
                 ]
            );
            $savedPositions[] = $position;
        }
        Faq::where($column,$columnId)->whereNotIn('position', $savedPositions)->delete();
    }
}
