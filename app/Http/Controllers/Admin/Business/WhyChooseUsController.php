<?php

namespace App\Http\Controllers\Admin\Business;

use App\Factory\Business\WhyChooseUsFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\WhyChooseUs\CreateRequest;
use App\Http\Requests\Business\WhyChooseUs\UpdateRequest;
use App\Models\Business\WhyChooseUs;
use Illuminate\Http\Request;

class WhyChooseUsController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.business.why_choose_us.index');
        return WhyChooseUsFactory::getDataTable();
    }

    public function create()
    {
        return view('admin.business.why_choose_us.create');
    }

    public function store(CreateRequest $request)
    {
        WhyChooseUsFactory::create(WhyChooseUs::class, $request->all());
        return redirect()->route('admin.why-choose-us.index')->with('success', 'Item created successfully');
    }

    public function edit(WhyChooseUs $whyChooseU)
    {
        $why_choose_us = $whyChooseU;
        return view('admin.business.why_choose_us.edit', compact('why_choose_us'));
    }

    public function update(UpdateRequest $request, WhyChooseUs $why_choose_u)
    {
        WhyChooseUsFactory::update($why_choose_u, $request->all());
        return redirect()->route('admin.why-choose-us.index')->with('success', 'Item updated successfully');
    }

    public function destroy(WhyChooseUs $why_choose_u)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Item deleted successfully'
        );

        if (!WhyChooseUsFactory::destroy($why_choose_u)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = WhyChooseUs::find($id);
        return response()->json(array(
            'status' => WhyChooseUsFactory::toggleStatus($instance),
        ));
    }
}
