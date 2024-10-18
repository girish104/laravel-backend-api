<?php

namespace App\Http\Controllers\Admin\Business;

use App\Factory\Business\CategoryFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\Category\CreateRequest;
use App\Http\Requests\Business\Category\UpdateRequest;
use App\Models\Business\Category;
use App\Models\Business\Type;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.business.category.index');
        return CategoryFactory::getDataTable();
    }

    public function create()
    {
        $business_types = Type::getActiveRecords();
        return view('admin.business.category.create', compact('business_types'));
    }

    public function store(CreateRequest $request)
    {
        CategoryFactory::create(Category::class, $request->all());
        return redirect()->route('admin.category.index')->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        $business_types = Type::getActiveRecords();
        return view('admin.business.category.edit', compact('category', 'business_types'));
    }

    public function update(UpdateRequest $request, Category $category)
    {
        CategoryFactory::update($category, $request->all());
        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Category deleted successfully'
        );

        if (!CategoryFactory::destroy($category)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Category::find($id);
        return response()->json(array(
            'status' => CategoryFactory::toggleStatus($instance),
        ));
    }
}
