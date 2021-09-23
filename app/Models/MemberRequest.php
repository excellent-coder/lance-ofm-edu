<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRequest extends Model
{
    use HasFactory;

    /**
     * Get the membership that owns the MemberRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'id');
    }
}
