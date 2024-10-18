<?php

namespace App\Http\Controllers\Admin;

use App\Factory\Other\TestimonialFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Testimonial\CreateRequest;
use App\Http\Requests\Testimonial\UpdateRequest;
use App\Models\Testimonial;
use App\Models\Business\Type;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.testimonial.index');
        return TestimonialFactory::getDataTable();
    }

    public function create()
    {
        return view('admin.testimonial.create');
    }

    public function store(CreateRequest $request)
    {
        TestimonialFactory::create(Testimonial::class, $request->all());
        // dd()
        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial created successfully');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    public function update(UpdateRequest $request, Testimonial $testimonial)
    {
        TestimonialFactory::update($testimonial, $request->all());
        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial updated successfully');
    }

    public function destroy(Testimonial $testimonial)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Testimonial deleted successfully'
        );

        if (!TestimonialFactory::destroy($testimonial)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Testimonial::find($id);
        return response()->json(array(
            'status' => TestimonialFactory::toggleStatus($instance),
        ));
    }
}
