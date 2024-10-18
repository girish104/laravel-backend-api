<?php

namespace App\Http\Controllers\Admin;

use App\Factory\Product\ProductFactory;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Business\Faq;
use App\Models\Business\Festival;
use App\Models\Business\Gift;
use App\Models\Business\SubSubCategory;
use App\Models\Business\Type;
use App\Models\Package\Package;
use App\Models\Package\PackageProduct;
use App\Models\Product;
use App\Models\Product\ProductFestival;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.product.index');
        return ProductFactory::getDataTable();
    }

    public function create()
    {
        $business_types   = Type::onlyActive('category', 'category.sub_category')->where(function ($q) {
            $q->whereRaw("LOWER(`title`) LIKE ? ", ['prod%']);
        })->first();
        $subSubCategories = SubSubCategory::orderBy('created_at')->get()->groupBy(['business_type', 'category_id', 'sub_category_id', 'type']);
        $packages = Package::where('status', Helper::STATUS_ACTIVE)->get();
        $gifts    = Gift::where('status', Helper::STATUS_ACTIVE)->get();

        $festivals         = Festival::getActiveRecords();

        return view('admin.product.create', compact('business_types', 'gifts', 'festivals', 'packages', 'subSubCategories'));
    }

    public function store(CreateRequest $request)
    {
        ProductFactory::create(Product::class, $request->all());
        return redirect()->route('admin.product.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $business_types   = Type::onlyActive('category', 'category.sub_category')->where(function ($q) {
            $q->whereRaw("LOWER(`title`) LIKE ? ", ['prod%']);
        })->first();

        $subSubCategories = SubSubCategory::orderBy('created_at')->get();
        $subSubCategoriesGroupedByType = (new Collection($subSubCategories))->groupBy(['type']);
        $subSubCategories = $subSubCategories->groupBy(['business_type', 'category_id', 'sub_category_id', 'type']);
        $packages = Package::where('status', Helper::STATUS_ACTIVE)->get();
        $gifts    = Gift::where('status', Helper::STATUS_ACTIVE)->get();
        $selectedPackages = PackageProduct::where('product_id', $product->id)->pluck('package_id')->toArray();

        $festivals         = Festival::getActiveRecords();
        $selectedFestivals = ProductFestival::where('product_id', $product->id)->pluck('festival_id')->toArray();
        $faqs              = Faq::where('product_id', $product->id)->get();

        return view('admin.product.edit', compact('product', 'packages', 'faqs', 'gifts', 'business_types', 'selectedFestivals', 'festivals', 'subSubCategories', 'selectedPackages', 'subSubCategoriesGroupedByType'));
    }

    public function update(UpdateRequest $request, Product $product)
    {
        ProductFactory::update($product, $request->all());
        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Product deleted successfully'
        );
        if (!ProductFactory::destroy($product)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }
        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Product::find($id);
        return response()->json(array(
            'status' => ProductFactory::toggleStatus($instance),
        ));
    }
}
