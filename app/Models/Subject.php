<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $timestamps = false;
    use HasFactory;

    /**
     * The userCategory that belong to the Subject
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Categories()
    {
        return $this->belongsToMany(
            UserCategory::class,
            'user_category_subject',
            'subject_id',
            'user_category_id',
        );
    }

    /**
     * Get all of the lessons for the Subject
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'subject_id', 'id');
    }
}
