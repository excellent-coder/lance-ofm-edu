<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingTag extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Get all of the settings for the SettingTag
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings()
    {
        return $this->hasMany(Setting::class, 'tag_id', 'id');
    }
}
