<?php

namespace App\Http\Controllers\Admin\Business;

use App\Factory\Business\GiftFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\Gift\CreateRequest;
use App\Http\Requests\Business\Gift\UpdateRequest;
use App\Models\Business\Gift;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.business.gift.index');
        return GiftFactory::getDataTable();
    }

    public function create()
    {
        return view('admin.business.gift.create');
    }

    public function store(CreateRequest $request)
    {
        GiftFactory::create(Gift::class, $request->all());
        return redirect()->route('admin.gift.index')->with('success', 'Gift Type created successfully');
    }

    public function edit(Gift $gift)
    {
        return view('admin.business.gift.edit', compact('gift'));
    }

    public function update(UpdateRequest $request, Gift $gift)
    {
        GiftFactory::update($gift, $request->all());
        return redirect()->route('admin.gift.index')->with('success', 'Gift Type updated successfully');
    }

    public function destroy(Gift $gift)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Gift Type deleted successfully'
        );

        if (!GiftFactory::destroy($gift)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Gift::find($id);
        return response()->json(array(
            'status' => GiftFactory::toggleStatus($instance),
        ));
    }
}
