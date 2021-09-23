<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Scs extends Authenticatable
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dob' => 'date',
    ];

    /**
     * The programs that belong to the SCStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function programs()
    {
        return $this->belongsToMany(
            Program::class,
            'scs_programs',
            'scs_id',
            'program_id'
        )->wherePivotNotNull('payment_id');
    }

    /**
     * Get all of the payments for the Scs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(ScsPayment::class, 'scs_id', 'id')
            ->where('status', 'successful');
    }
}
