<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Student extends Authenticatable
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
    public function authPrograms()
    {
        return $this->belongsToMany(
            Program::class,
            'student_programs',
            'student_id',
            'program_id'
        )->wherePivot('session_id', config('web.session_id'))
            ->wherePivot('level_id', auth('pgs')->user()->level_id)->first();
    }

    /**
     * Get the program that owns the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }


    /**
     * Get the session that the user registered
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id', 'id');
    }

    /**
     * Get the application request made by the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appRequest()
    {
        return $this->belongsTo(StudentRequest::class, 'student_request_id', 'id');
    }



    /**
     * The programs that belong to the SCStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function programs()
    {
        return $this->belongsToMany(
            Program::class,
            'student_programs',
            'student_id',
            'program_id'
        );
    }

    /**
     * Get all of the payments for the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(StudentPayment::class, 'student_id', 'id');
    }

    /**
     * Get the level that owns the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
}
