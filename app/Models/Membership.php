<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    /**
     * Get all of the members for the Membership
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'membership_id', 'id');
    }


    /**
     * Get all of the pending members for the Membership
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pending()
    {
        return $this->hasMany(MemberRequest::class, 'membership_id', 'id');
    }

    /**
     * Get all of the children for the PostCat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }


    /**
     * Get the parent that owns the PostCat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }
}
