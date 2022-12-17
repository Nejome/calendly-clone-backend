<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventReminder;

class SendEventsReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Events Reminders';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $events = Event::with(['eventType', 'eventType.user'])
            ->whereDate('day', today())
            ->whereTime('time', now()->addHour())
            ->get();

        foreach ($events as $event) {
            //To Event Owner
            Mail::to($event->eventType->user->email)->send(new EventReminder([
                'name' => $event->eventType->user->name,
                'event_type' => $event->eventType->name,
                'with_name' => $event->invited_name,
                'with_email' => $event->invited_email,
                'date_time' => $event->time.', '.$event->day,
                'join_link' => $event->start_url,
                'password' => $event->password,
            ]));

            //To Invited
            Mail::to($event->invited_email)->send(new EventReminder([
                'name' => $event->invited_name,
                'event_type' => $event->eventType->name,
                'with_name' => $event->eventType->user->name,
                'with_email' => $event->eventType->user->email,
                'date_time' => $event->time.', '.$event->day,
                'join_link' => $event->join_url,
                'password' => $event->password,
            ]));
        }
    }
}
