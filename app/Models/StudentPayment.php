<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    use HasFactory;

    /**
     * Get the studentRequest that owns the StudentPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studentRequest()
    {
        return $this->belongsTo(StudentRequest::class, 'student_request_id', 'id');
    }
}
