<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * Get the receivers that owns the Notification
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receivers()
    {
        return $this->belongsTo(NotificationCat::class, 'category_id', 'id');
    }

    /**
     * Get all of the replies for the Notification
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(NotificationReply::class, 'notification_id', 'id');
    }
}
