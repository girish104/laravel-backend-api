<?php

namespace App\Http\Controllers\Admin\Business;

use App\Factory\Business\TypeFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\Type\CreateRequest;
use App\Http\Requests\Business\Type\UpdateRequest;
use App\Models\Business\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.business.type.index');
        return TypeFactory::getDataTable();
    }

    public function create()
    {
        return view('admin.business.type.create');
    }

    public function store(CreateRequest $request)
    {
        TypeFactory::create(Type::class, $request->all());
        return redirect()->route('admin.business-type.index')->with('success', 'Business Type created successfully');
    }

    public function edit(Type $business_type)
    {
        return view('admin.business.type.edit', compact('business_type'));
    }

    public function update(UpdateRequest $request, Type $business_type)
    {
        TypeFactory::update($business_type, $request->all());
        return redirect()->route('admin.business-type.index')->with('success', 'Business Type updated successfully');
    }

    public function destroy(Type $business_type)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Business Type deleted successfully'
        );

        if (!TypeFactory::destroy($business_type)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Type::find($id);
        return response()->json(array(
            'status' => TypeFactory::toggleStatus($instance),
        ));
    }
}
