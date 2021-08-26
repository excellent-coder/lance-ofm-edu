<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationCat extends Model
{
    use HasFactory;

    public $timestamps = null;

    /**
     * Get all of the events for the NotificationCat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function noticess()
    {
        return $this->hasMany(Notification::class, 'category_id', 'id');
    }
}
