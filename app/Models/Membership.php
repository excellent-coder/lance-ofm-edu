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
        return $this->hasMany(Application::class, 'item_id', 'id')
            ->where('applying_for', 'membership');
    }
}
