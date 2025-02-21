<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EventResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Event::query();
        $relations = ['user', 'attendee', 'attendee.user'];

        foreach ($relations as $relation) {
            $query->when(
                $this->shouldIncludeRelation($relation), 
                fn($q) => $q->with($relation)
            );
        }

        //return EventResource::collection(Event::with('user')->paginate());
        //return EventResource::collection($query->latest()->paginate());
        return $query->latest();
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

        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Event $event)
    {
        $event->load('user', 'attendee');
        return new EventResource($event);
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

    protected function shouldIncludeRelation(string $relation) 
    {
        $include = request()->query('include');

        if (!$include) {
            return false;
        }

        $relation = array_map('trim', explode(',', $include));

        return in_array($relation, $relation);
    }
}
