<?php

namespace App\Http\Controllers\Admin;

use App\Factory\Service\ServiceFactory;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\CreateRequest;
use App\Http\Requests\Service\UpdateRequest;
use App\Models\Business\Faq;
use App\Models\Business\Festival;
use App\Models\Business\SubSubCategory;
use App\Models\Business\Type;
use App\Models\Package\Package;
use App\Models\Package\PackageService;
use App\Models\Service\Service;
use App\Models\Service\ServiceFestival;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.service.index');
        return ServiceFactory::getDataTable();
    }

    public function create()
    {
        $business_types   = Type::onlyActive('category', 'category.sub_category')->where(function ($q) {
            $q->whereRaw("LOWER(`title`) LIKE ? ", ['servic%']);
        })->first();
        $packages = Package::where('status', Helper::STATUS_ACTIVE)->get();
        $subSubCategories = SubSubCategory::orderBy('created_at')->get()->groupBy(['business_type', 'category_id', 'sub_category_id']);
        $festivals         = Festival::getActiveRecords();
        return view('admin.service.create', compact('business_types', 'festivals',  'packages', 'subSubCategories'));
    }

    public function store(CreateRequest $request)
    {
        ServiceFactory::create(Service::class, $request->all());
        return redirect()->route('admin.service.index')->with('success', 'Service created successfully');
    }

    public function edit(Service $service)
    {
        $business_types   = Type::onlyActive('category', 'category.sub_category')->where(function ($q) {
            $q->whereRaw("LOWER(`title`) LIKE ? ", ['servic%']);
        })->first();

        $subSubCategories  = SubSubCategory::orderBy('created_at')->get()->groupBy(['business_type', 'category_id', 'sub_category_id']);
        $packages          = Package::where('status', Helper::STATUS_ACTIVE)->get();
        $selectedPackages  = PackageService::where('service_id', $service->id)->pluck('package_id')->toArray();

        $festivals         = Festival::getActiveRecords();
        $selectedFestivals = ServiceFestival::where('service_id', $service->id)->pluck('festival_id')->toArray();
        $faqs              = Faq::where('service_id', $service->id)->get();

        return view('admin.service.edit', compact('service', 'business_types', 'faqs', 'selectedFestivals', 'festivals', 'selectedPackages',  'packages', 'subSubCategories'));
    }

    public function update(UpdateRequest $request, Service $service)
    {
        ServiceFactory::update($service, $request->all());
        return redirect()->route('admin.service.index')->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Service deleted successfully'
        );
        if (!ServiceFactory::destroy($service)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }
        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Service::find($id);
        return response()->json(array(
            'status' => ServiceFactory::toggleStatus($instance),
        ));
    }
}
