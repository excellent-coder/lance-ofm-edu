<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationCat extends Model
{
    use HasFactory;

    /**
     * Get all of the publications for the PublicationCat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publications()
    {
        return $this->hasMany(Publication::class, 'cat_id', 'id');
    }
}
