<?php

namespace App\Http\Controllers\Admin\Business;

use App\Factory\Business\SubSubCategoryFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\SubSubCategory\CreateRequest;
use App\Http\Requests\Business\SubSubCategory\UpdateRequest;

use App\Models\Business\SubSubCategory;
use App\Models\Business\Type;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class SubSubCategoryController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.business.sub-sub-category.index');
        return SubSubCategoryFactory::getDataTable();
    }

    public function create()
    {
        $business_types   = Type::onlyActive('category', 'category.sub_category')->whereNot('title', 'Celebrity')->get();
        $subSubCategories = SubSubCategory::orderBy('created_at')->get()->groupBy(['business_type', 'category_id', 'sub_category_id', 'type']);
        return view('admin.business.sub-sub-category.create', compact('business_types', 'subSubCategories'));
    }

    public function store(CreateRequest $request)
    {
        SubSubCategoryFactory::create(SubSubCategory::class, $request->all());
        return redirect()->route('admin.sub-sub-category.index')->with('success', 'Sub Category created successfully');
    }

    public function edit(SubSubCategory $sub_sub_category)
    {
        $business_types   = Type::onlyActive('category', 'category.sub_category')->whereNot('title', 'Celebrity')->get();
        $subSubCategories = SubSubCategory::orderBy('created_at')->get();
        // $subSubCategoriesGroupedByType = (new Collection($subSubCategories))->groupBy(['type']);
        $subSubCategories = $subSubCategories->groupBy(['business_type', 'category_id', 'sub_category_id', 'type']);

        return view('admin.business.sub-sub-category.edit', compact('sub_sub_category', 'subSubCategories', 'business_types'));
    }

    public function update(UpdateRequest $request, SubSubCategory $sub_sub_category)
    {
        SubSubCategoryFactory::update($sub_sub_category, $request->all());
        return redirect()->route('admin.sub-sub-category.index')->with('success', 'Sub Category updated successfully');
    }

    public function destroy(SubSubCategory $sub_sub_category)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Sub Category deleted successfully'
        );

        if (!SubSubCategoryFactory::destroy($sub_sub_category)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = SubSubCategory::find($id);
        return response()->json(array(
            'status' => SubSubCategoryFactory::toggleStatus($instance),
        ));
    }
}
