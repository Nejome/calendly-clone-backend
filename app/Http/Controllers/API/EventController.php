<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Events\EventCreated;

class EventController extends Controller
{
    public function list()
    {
        $user = auth()->user();

        $events = $user->events->groupBy('day');

        $events->each(fn($event) => $event->load(['eventType']));

        return response()->json($events);
    }

    public function getSingle(Event $event)
    {
        $event->load(['eventType', 'eventType.user']);

        return response()->json($event);
    }

    public function store(EventRequest $request)
    {
        $event = Event::create($request->validated());

        event(new EventCreated($event));

        return response()->json(['message', 'Event created successfully', 'id' => $event->id]);
    }
}
