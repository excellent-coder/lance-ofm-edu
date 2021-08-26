<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    /**
     * Get all of the pending applicatioons for a Program
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentsPending()
    {
        return $this->hasMany(Program::class, 'item_id', 'id')
            ->where('applyging_for', 'student');
    }

    /**
     * Get the student that owns the Application
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user($table = 'student')
    {
        $table = preg_replace(['/(member.*)/', '/(student.*)/'], ['member', 'student'], $table);
        $class = ucfirst($table);
        $class = "\App\Models\\$class";

        return $this->belongsTo(
            $class,
            'id', //key available in applications
            'application_id' // key matching id(key in this table) in other table
        );
    }
}
