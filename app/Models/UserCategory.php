<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    public function parent()
    {
        return $this->belongsTo(UserCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(UserCategory::class, 'parent_id');
    }

    // recursive, loads all descendants
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    public function getUsersAttribute()
    {
        return 'comming soon';
    }
    public function getVisibleToAttribute()
    {
        return $this->visibility == 1 ? 'all' : 'admin';
    }

    /**
     * Get all of the applications for the UserCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'user_category_id', 'id');
    }

    /**
     * The subjects that belong to the UserCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'user_category_subject', 'user_category_id', 'subject_id');
    }

    public function superChildren()
    {
        return $this->hasMany(UserCategory::class, 'super_parent'); //->select(['id']);
    }

    public function superParent()
    {
        return $this->belongsTo(UserCategory::class, 'super_parent', 'id'); //->select(['id']);
    }
}
