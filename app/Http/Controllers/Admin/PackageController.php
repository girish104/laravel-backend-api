<?php

namespace App\Http\Controllers\Admin;

use App\Factory\Package\PackageFactory;
use App\Http\Controllers\Controller;
use App\Models\Business\Festival;
// use App\Http\Requests\Package\CreateRequest;
// use App\Http\Requests\Package\UpdateRequest;
use App\Models\Business\SubSubCategory;
use App\Models\Business\Type;
use App\Models\Package\Package;
use App\Models\Package\PackageFestival;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.package.index');
        return PackageFactory::getDataTable();
    }

    public function create()
    {
        $festivals        = Festival::getActiveRecords();
        
        $business_types   = Type::onlyActive('category', 'category.sub_category')->where(function ($q) {
            $q->whereRaw("LOWER(`title`) LIKE ? ", ['packag%']);
        })->first();
        
        $subSubCategories = SubSubCategory::orderBy('created_at')->get()->groupBy(['business_type', 'category_id', 'sub_category_id', 'type']);

        return view('admin.package.create', compact('festivals', 'subSubCategories', 'business_types'));
    }


    // public function store(CreateRequest $request)
    public function store(Request $request)
    {
        PackageFactory::create(Package::class, $request->all());
        return redirect()->route('admin.package.index')->with('success', 'Package created successfully');
    }

    public function edit(Package $package)
    {
        $business_types   = Type::onlyActive('category', 'category.sub_category')->where(function ($q) {
            $q->whereRaw("LOWER(`title`) LIKE ? ", ['packag%']);
        })->first();

        $subSubCategories = SubSubCategory::orderBy('created_at')->get();
        $subSubCategoriesGroupedByType = (new Collection($subSubCategories))->groupBy(['type']);
        $subSubCategories = $subSubCategories->groupBy(['business_type', 'category_id', 'sub_category_id', 'type']);

        $festivals         = Festival::getActiveRecords();
        $selectedFestivals = PackageFestival::where('package_id', $package->id)->pluck('festival_id')->toArray();


        return view('admin.package.edit', compact('package', 'business_types', 'selectedFestivals', 'festivals',  'subSubCategories', 'subSubCategoriesGroupedByType'));
    }

    // public function update(UpdateRequest $request, Package $package)
    public function update(Request $request, Package $package)
    {
        PackageFactory::update($package, $request->all());
        return redirect()->route('admin.package.index')->with('success', 'Package updated successfully');
    }

    public function destroy(Package $package)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Package deleted successfully'
        );
        if (!PackageFactory::destroy($package)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }
        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Package::find($id);
        return response()->json(array(
            'status' => PackageFactory::toggleStatus($instance),
        ));
    }
}
