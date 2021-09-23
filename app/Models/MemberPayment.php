<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPayment extends Model
{
    use HasFactory;

    /**
     * Get the memberRequest that owns the MemberPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function memberRequest()
    {
        return $this->belongsTo(MemberRequest::class, 'member_request_id', 'id');
    }
}
