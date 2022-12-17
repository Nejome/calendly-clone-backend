<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type_id',
        'invited_name',
        'invited_email',
        'day',
        'time',
        'start_url',
        'join_url',
        'password'
    ];

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }
}
