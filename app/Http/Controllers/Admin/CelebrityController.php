<?php

namespace App\Http\Controllers\Admin;

use App\Factory\Celebrity\CelebrityFactory;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Celebrity\CreateRequest;
use App\Http\Requests\Celebrity\UpdateRequest;
use App\Models\Business\SubSubCategory;
use App\Models\Business\Type;
use App\Models\Celebrity;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Http\Request;

class CelebrityController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.celebrity.index');
        return CelebrityFactory::getDataTable();
    }

    public function create()
    {
        $business_types   = Type::onlyActive('category', 'category.sub_category')->where(function ($q) {
            $q->whereRaw("LOWER(`title`) LIKE ? ", ['celebrit%']);
        })->first();
        $subSubCategories = SubSubCategory::orderBy('created_at')->get()->groupBy(['business_type', 'category_id', 'sub_category_id', 'type']);
        return view('admin.celebrity.create', compact('business_types', 'subSubCategories'));
    }

    public function store(CreateRequest $request)
    {
        CelebrityFactory::create(Celebrity::class, $request->all());
        return redirect()->route('admin.celebrity.index')->with('success', 'Celebrity created successfully');
    }

    public function edit(Celebrity $celebrity)
    {
        $business_types   = Type::onlyActive('category', 'category.sub_category')->where(function ($q) {
            $q->whereRaw("LOWER(`title`) LIKE ? ", ['celebrit%']);
        })->first();
        $subSubCategories = SubSubCategory::orderBy('created_at')->get()->groupBy(['business_type', 'category_id', 'sub_category_id', 'type']);
        return view('admin.celebrity.edit', compact('celebrity', 'business_types', 'subSubCategories'));
    }

    public function update(UpdateRequest $request, Celebrity $celebrity)
    {
        CelebrityFactory::update($celebrity, $request->all());
        return redirect()->route('admin.celebrity.index')->with('success', 'Celebrity updated successfully');
    }

    public function destroy(Celebrity $celebrity)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Celebrity deleted successfully'
        );
        if (!CelebrityFactory::destroy($celebrity)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }
        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Celebrity::find($id);
        return response()->json(array(
            'status' => CelebrityFactory::toggleStatus($instance),
        ));
    }
}
