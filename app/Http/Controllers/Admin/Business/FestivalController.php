<?php

namespace App\Http\Controllers\Admin\Business;

use App\Factory\Business\FestivalFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\Festival\CreateRequest;
use App\Http\Requests\Business\Festival\UpdateRequest;
use App\Models\Business\Festival;
use App\Models\Business\Type;
use Illuminate\Http\Request;

class FestivalController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.business.festival.index');
        return FestivalFactory::getDataTable();
    }

    public function create()
    {
        return view('admin.business.festival.create');
    }

    public function store(CreateRequest $request)
    {
        FestivalFactory::create(Festival::class, $request->all());
        return redirect()->route('admin.festival.index')->with('success', 'Festival created successfully');
    }

    public function edit(Festival $festival)
    {
        return view('admin.business.festival.edit', compact('festival'));
    }

    public function update(UpdateRequest $request, Festival $festival)
    {
        FestivalFactory::update($festival, $request->all());
        return redirect()->route('admin.festival.index')->with('success', 'Festival updated successfully');
    }

    public function destroy(Festival $festival)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Festival deleted successfully'
        );

        if (!FestivalFactory::destroy($festival)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Festival::find($id);
        return response()->json(array(
            'status' => FestivalFactory::toggleStatus($instance),
        ));
    }
}
