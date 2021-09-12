<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRequest extends Model
{
    use HasFactory;

    /**
     * Get the program that owns the StudentRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    /**
     * Get the paidInduction associated with the StudentRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paidInduction()
    {
        return $this->hasOne(StudentPayment::class, 'student_request_id', 'id')
            ->where('status', 'successful');
    }
}
