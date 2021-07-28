<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $appends = ['f_price', 'f_h_price'];

    /**
     * Get all of the images for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductGallery::class, 'product_id', 'id')
            ->orderBy('featured', 'DESC');
    }

    /**
     * Get the featured image associated with the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function img()
    {
        return $this->hasOne(ProductGallery::class, 'product_id', 'id')
            ->select(['id', 'product_id', 'image', 'featured'])
            ->orderBy('featured', 'DESC');
    }

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProductCat::class, 'product_cat_id', 'id');
    }

    public function getFPriceAttribute()
    {
        return '₦ ' . number_format($this->price, 2);
    }
    public function getFHPriceAttribute()
    {
        return '₦ ' . number_format($this->high_price, 2);
    }
}
