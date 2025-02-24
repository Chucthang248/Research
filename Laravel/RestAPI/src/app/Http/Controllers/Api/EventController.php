<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EventResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\CanLoadRelationship;
use App\Models\Event;

class EventController extends Controller
{

    use CanLoadRelationship;

    private array $relations = ['user', 'attendee', 'attendee.user'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Event::query();
        

        $this->loadRelationships($query, $this->relations);

        return EventResource::collection($query->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]),
            'user_id' => $request->user_id
        ]);

        return new EventResource($this->loadRelationships($event, null));
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Event $event)
    {
        $event->load('user', 'attendee');
        return new EventResource($this->loadRelationships($event, null));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $event->update(
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'sometimes|date',
                'end_time' => 'sometimes|date|after:start_time',
            ])
        );

        return $event;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json([
            'message' => 'Event delete successful !'
        ]);
    }


}
