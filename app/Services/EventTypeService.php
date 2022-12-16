<?php

namespace App\Services;

use Carbon\CarbonPeriod;

class EventTypeService
{
    public static function getTimeslots($eventType, $day): array
    {
        $period = new CarbonPeriod('09:00', $eventType->duration.' minutes', '17:00');

        $slots = [];

        foreach($period as $item) {
            $exist = $eventType->events()->where('day', $day)->where('time', $item)->first();

            if(!$exist){
                array_push($slots, $item->format("H:i"));
            }
        }

        return $slots;
    }
}
