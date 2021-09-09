<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScsPayment extends Model
{
    use HasFactory;

    /**
     * Get the student that owns the ScsPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(SCStudent::class, 's_c_student_id', 'id');
    }
}
