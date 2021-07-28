<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
    use HasFactory;

    /**
     * Get all of the parents for the ProductCat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parents()
    {
        return $this->hasMany(self::class, 'super_parent_id', 'id')->whereNull('parent_id');
    }

    /**
     * Get all of the parents for the ProductCat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }


    public function superChildren()
    {
        return $this->hasMany(self::class, 'super_parent');
    }


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function superParent()
    {
        return $this->belongsTo(self::class, 'super_parent_id', 'id');
    }

    /**
     * Get all of the products for the ProductCat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_cat_id', 'id');
    }
}
