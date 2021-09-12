<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SCStudent extends Authenticatable
{
    use HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
            's_c_student_id',
            'program_id'
        )->wherePivotNotNull('approved_at')
            ->withPivot(
                'id',
                'session_id',
                'level_id',
                'approved_at',
                'start_at',
                'end_at',
                'created_at'
            );
        // ->wherePivot('start_at', config('web.session_id'))
        //     ->wherePivot('level_id', auth('scs')->user()->level_id);
    }

    /**
     * The programs that belong to the SCStudent
     *
     * @
     * ret
     * urn \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getScPrograms()
    {
        return 'true';
    }

    /**
     * Get the user associated with the SCStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function appFee()
    {
        return $this->hasOne(ScsPayment::class, 's_c_student_id', 'id')
            ->where('tag', 'application');
    }


    /**
     * Get all of the allPrograms for the SCStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allPrograms()
    {
        return $this->belongsToMany(
            Program::class,
            'scs_programs',
            's_c_student_id',
            'program_id'
        )->withPivot(
            'id',
            'session_id',
            'level_id',
            'approved_at',
            'start_at',
            'end_at',
            'created_at'
        );
    }

    /**
     * Get all of the payments for the SCStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(ScsPayment::class, 's_c_student_id', 'id');
    }
}
