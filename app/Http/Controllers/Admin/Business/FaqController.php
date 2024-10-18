<?php

namespace App\Http\Controllers\Admin\Business;

use App\Factory\Business\FaqFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\Faq\CreateRequest;
use App\Http\Requests\Business\Faq\UpdateRequest;
use App\Models\Business\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.business.faq.index');
        return FaqFactory::getDataTable();
    }

    public function create()
    {
        return view('admin.business.faq.create');
    }

    public function store(CreateRequest $request)
    {
        FaqFactory::create(Faq::class, $request->all());
        return redirect()->route('admin.faq.index')->with('success', 'Faq created successfully');
    }

    public function edit(Faq $faq)
    {
        return view('admin.business.faq.edit', compact('faq'));
    }

    public function update(UpdateRequest $request, Faq $faq)
    {
        FaqFactory::update($faq, $request->all());
        return redirect()->route('admin.faq.index')->with('success', 'Faq updated successfully');
    }

    public function destroy(Faq $faq)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Faq deleted successfully'
        );

        if (!FaqFactory::destroy($faq)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Faq::find($id);
        return response()->json(array(
            'status' => FaqFactory::toggleStatus($instance),
        ));
    }
}
