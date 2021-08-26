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
        return $this->hasMany(Application::class, 'item_id', 'id')
            ->whereRaw("`applications`.`applying_for` = 'student'
            AND `applications`.`approved_at` IS NULL");
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
}
