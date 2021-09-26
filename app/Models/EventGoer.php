<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventGoer extends Model
{
    use HasFactory;

    /**
     * Get the event that owns the EventGoer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id')->whereActive(1)
            ->where('start_at', '<', date('Y-m-d H:i:s'))
            ->where('end_at', '>', date('Y-m-d H:i:s'));
    }
}
