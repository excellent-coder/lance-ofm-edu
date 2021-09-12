<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScsProgram extends Model
{
    use HasFactory;
    protected $casts = [
        'start_at' => 'datetime:Y-m-d H:00:00',
        'end_at' => 'datetime:Y-m-d H:00:00',
        'approved_at' => 'datetime:Y-m-d H:00:00',
    ];

    /**
     * Get the program that owns the ScsProgram
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(SCStudent::class, 's_c_student_id', 'id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
}
