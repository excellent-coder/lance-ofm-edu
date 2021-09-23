<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    /**
     * Get all of the students for the Program
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'program_id', 'id');
    }

    /**
     * Get all of the students for the Program
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentsPending()
    {
        return $this->hasMany(StudentRequest::class, 'program_id', 'id')
            ->whereNull('approved_at')->where('reviewed', '!=', '1');
    }

    // /**
    //  * Get all of the students for the Program
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function scs()
    // {
    //     return $this->hasMany(Student::class, 'program_id', 'id');
    // }

    /**
     * Get all of the courses for the Program for short course student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pCourses()
    {
        return $this->hasMany(Course::class, 'program_id', 'id')
            ->where('visibility', '!=', 3);
    }

    /**
     * Get all of the courses for the Program for short course student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sCourses()
    {
        return $this->hasMany(Course::class, 'program_id', 'id')
            ->where('visibility', '!=', 2);
    }
}
