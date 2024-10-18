<?php

namespace App\Http\Controllers\Admin\Business;

use App\Factory\Business\LocationFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\Location\CreateRequest;
use App\Http\Requests\Business\Location\UpdateRequest;
use App\Models\Business\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.business.location.index');
        return LocationFactory::getDataTable();
    }

    public function create()
    {
        return view('admin.business.location.create');
    }

    public function store(CreateRequest $request)
    {
        LocationFactory::create(Location::class, $request->all());
        return redirect()->route('admin.location.index')->with('success', 'Location created successfully');
    }

    public function edit(Location $location)
    {
        return view('admin.business.location.edit', compact('location'));
    }

    public function update(UpdateRequest $request, Location $location)
    {
        LocationFactory::update($location, $request->all());
        return redirect()->route('admin.location.index')->with('success', 'Location updated successfully');
    }

    public function destroy(Location $location)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Location deleted successfully'
        );

        if (!LocationFactory::destroy($location)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Location::find($id);
        return response()->json(array(
            'status' => LocationFactory::toggleStatus($instance),
        ));
    }
}
