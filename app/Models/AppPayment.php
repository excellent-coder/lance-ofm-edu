<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPayment extends Model
{
    use HasFactory;

    /**
     * Get the applicant that owns the AppPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applicant()
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }
}
