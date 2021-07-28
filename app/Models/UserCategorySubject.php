<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategorySubject extends Model
{
    use HasFactory;
    protected $table = "user_category_subject";
    public $timestamps = false;
    protected $fillable = [
        'user_category_id',
        'subject_id'
    ];
}
