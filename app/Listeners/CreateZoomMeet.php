<?php

namespace App\Listeners;

use App\Events\EventCreated;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use MacsiDigital\Zoom\Facades\Zoom;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventReminder;

class CreateZoomMeet
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EventCreated  $event
     * @return void
     */
    public function handle(EventCreated $event)
    {
        $user = Zoom::user()->first();

        $meetingData = [
            'topic' => $event->event->eventType->name,
            'duration' => $event->event->eventType->duration,
            'start_time' => Carbon::createFromFormat('Y-m-d H:i', $event->event->day.' '.$event->event->time),
            'timezone' => 'Africa/Cairo'
        ];

        $meeting = Zoom::meeting()->make($meetingData);

        $meeting->settings()->make([
            'join_before_host' => false,
            'host_video' => false,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'waiting_room' => true,
            'approval_type' => config('zoom.approval_type'),
            'audio' => config('zoom.audio'),
            'auto_recording' => config('zoom.auto_recording')
        ]);

        $created_meeting = $user->meetings()->save($meeting);

        $event->event->update([
           'start_url' => $created_meeting->start_url,
           'join_url' => $created_meeting->join_url,
           'password' => $created_meeting->password
        ]);

        $data['name'] = $event->event->eventType->user->name;
        $data['event_type'] = $event->event->eventType->name;
        $data['with_name'] = $event->event->invited_name;
        $data['with_email'] = $event->event->invited_email;
        $data['date_time'] = $event->event->time.', '.$event->event->day;
        $data['join_link'] = $created_meeting->start_url;
        $data['password'] = $created_meeting->password;

        Mail::to($event->event->eventType->user->email)->send(new EventReminder($data));
    }
}
