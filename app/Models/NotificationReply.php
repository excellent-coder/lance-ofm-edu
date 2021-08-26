<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationReply extends Model
{
    use HasFactory;

    /**
     * Get the table that owns the NotificationReply
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usertable()
    {
        return $this->belongsTo(UserTable::class, 'user_table_id', 'id');
    }
}
