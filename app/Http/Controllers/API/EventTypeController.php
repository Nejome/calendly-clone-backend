<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventTypeRequest;
use App\Models\EventType;
use App\Services\EventTypeService;

class EventTypeController extends Controller
{
    public function list()
    {
        $user = auth()->user();

        $eventTypes = $user->eventTypes;

        return response()->json($eventTypes);
    }

    public function store(EventTypeRequest $request)
    {
        EventType::create(array_merge($request->validated(), ['user_id' => auth()->id()]));

        return response()->json(['message' => 'Event type created successfully']);
    }

    public function getSingle(EventType $eventType)
    {
        $eventType->load(['user']);

        return response()->json($eventType);
    }

    public function getTimeSlots(EventType $eventType)
    {
        $slots = EventTypeService::getTimeslots($eventType, request()->get('day'));

        return response()->json($slots);
    }
}
