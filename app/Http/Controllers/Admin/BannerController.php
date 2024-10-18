<?php

namespace App\Http\Controllers\Admin;

use App\Factory\Other\BannerFactory;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\CreateRequest;
use App\Http\Requests\Banner\UpdateRequest;
use App\Models\Banner;
use App\Models\Business\Type;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.banner.index');
        return BannerFactory::getDataTable();
    }

    public function create()
    {
        $business_types   = Type::onlyActive('category', 'category.sub_category')->get();

        return view('admin.banner.create',  compact('business_types'));
    }

    public function store(CreateRequest $request)
    {
        BannerFactory::create(Banner::class, $request->all());
        return redirect()->route('admin.banner.index',)->with('success', 'Banner created successfully');
    }

    public function edit(Banner $banner)
    {
        $business_types   = Type::onlyActive('category', 'category.sub_category')->get();

        return view('admin.banner.edit', compact('banner', 'business_types'));
    }

    public function update(UpdateRequest $request, Banner $banner)
    {
        BannerFactory::update($banner, $request->all());
        return redirect()->route('admin.banner.index')->with('success', 'Banner updated successfully');
    }

    public function destroy(Banner $banner)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Banner deleted successfully'
        );

        if (!BannerFactory::destroy($banner)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Banner::find($id);
        return response()->json(array(
            'status' => BannerFactory::toggleStatus($instance),
        ));
    }
}
