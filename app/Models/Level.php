<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Get all of the students for the Level
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'level', 'id');
    }


    /**
     * Get all of the results for the Level
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results($studentId)
    {
        return $this->hasMany(StudentResult::class, 'level_id', 'id')->where('student_id', $studentId);
    }
}
