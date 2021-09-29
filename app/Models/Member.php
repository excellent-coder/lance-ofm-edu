<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the membership that owns the Member
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'id');
    }

    /**
     * Get all of the purchases for the Publication
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publications()
    {
        return $this->hasMany(PublicationPurchase::class, 'member_id', 'id')->where('status', 'successful');
    }

    /**
     * Get all of the events for the Member
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventGoers()
    {
        return $this->hasMany(EventGoer::class, 'member_id', 'id')->wherePaid(1);
    }

    /**
     * Get the paidAnnual associated with the Member
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paidAnnual()
    {
        return $this->hasOne(MemberAnnual::class, 'member_id', 'id')
            ->where('end_at', '>', 'now()');
    }

    /**
     * Get all of the payments for the Member
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(MemberPayment::class, 'member_id', 'id');
        // ->where('transaction_id', '!=', null);
    }
}
