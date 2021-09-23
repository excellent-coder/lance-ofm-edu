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
        return $this->belongsTo(Scs::class, 'scs_id', 'id');
    }

    /**
     * Get the program that owns the ScsPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
}
