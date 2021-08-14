<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagePart extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Get all of the images for the ImagePart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'part_id', 'id');
    }

    /**
     * Get all of the images for the ImagePart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function active()
    {
        return $this->hasMany(Image::class, 'part_id', 'id')
            ->where('active', 1);
    }
}
