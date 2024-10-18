<?php

namespace App\Http\Controllers\Admin\Business;

use App\Factory\Business\EventFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\Event\CreateRequest;
use App\Http\Requests\Business\Event\UpdateRequest;
use App\Models\Business\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.business.event.index');
        return EventFactory::getDataTable();
    }

    public function create()
    {
        return view('admin.business.event.create');
    }

    public function store(CreateRequest $request)
    {
        EventFactory::create(Event::class, $request->all());
        return redirect()->route('admin.event.index')->with('success', 'Event  created successfully');
    }

    public function edit(Event $event)
    {
        return view('admin.business.event.edit', compact('event'));
    }

    public function update(UpdateRequest $request, Event $event)
    {
        EventFactory::update($event, $request->all());
        return redirect()->route('admin.event.index')->with('success', 'Event  updated successfully');
    }

    public function destroy(Event $event)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'Event  deleted successfully'
        );

        if (!EventFactory::destroy($event)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = Event::find($id);
        return response()->json(array(
            'status' => EventFactory::toggleStatus($instance),
        ));
    }
}
