<?php

namespace App\Http\Controllers\Admin\Business;

use App\Factory\Business\SubCategoryFactory;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\SubCategory\CreateRequest;
use App\Http\Requests\Business\SubCategory\UpdateRequest;
use App\Models\Business\CategoryFestival;
use App\Models\Business\Festival;
use App\Models\Business\SubCategory;
use App\Models\Business\Type;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.business.sub-category.index');
        return SubCategoryFactory::getDataTable();
    }

    public function create()
    {
        $business_types = Type::getActiveRecords('category');
        $festivals = Festival::getActiveRecords();
        return view('admin.business.sub-category.create', compact('business_types', 'festivals'));
    }

    public function store(CreateRequest $request)
    {
        SubCategoryFactory::create(SubCategory::class, $request->all());
        static::saveFestivalDetails(Helper::getTransactionResult(), $request->festivals);
        return redirect()->route('admin.sub-category.index')->with('success', 'Sub Category created successfully');
    }

    public function edit(SubCategory $sub_category)
    {
        $business_types = Type::getActiveRecords('category');
        $festivals      = Festival::getActiveRecords();
        $selectedFestivals = CategoryFestival::where('sub_category_id', $sub_category->id)->where('category_id', $sub_category->category_id)->pluck('festival_id')->toArray();
        return view('admin.business.sub-category.edit', compact('sub_category', 'selectedFestivals', 'business_types', 'festivals'));
    }

    public function update(UpdateRequest $request, SubCategory $sub_category)
    {
        SubCategoryFactory::update($sub_category, $request->all());
        static::saveFestivalDetails($sub_category, $request->festivals);
        return redirect()->route('admin.sub-category.index')->with('success', 'Sub Category updated successfully');
    }

    public function destroy(SubCategory $sub_category)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Sub Category deleted successfully'
        );

        if (!SubCategoryFactory::destroy($sub_category)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = SubCategory::find($id);
        return response()->json(array(
            'status' => SubCategoryFactory::toggleStatus($instance),
        ));
    }

    public static function saveFestivalDetails($instance, $festivals){
        $festivals = $festivals ?? [];

        if (!empty($festivals)) foreach ($festivals as $festival) 
        Helper::safeTransaction(function() use ($instance, $festival) {
            CategoryFestival::updateOrCreate(
                [
                   'category_id'     => $instance->category_id,
                   'sub_category_id' => $instance->id,
                   'festival_id'     => $festival,
                ],
                [],
            );
        });

        Helper::safeTransaction(function() use ($instance, $festivals) {
            CategoryFestival::where('category_id', $instance->category_id)->where('sub_category_id', $instance->id)->whereNotIn('festival_id', $festivals)->delete();
        });
    }
}
