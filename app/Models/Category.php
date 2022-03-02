<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $guarded = ['id'];

    // Relationships
    public function products()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function faqs()
    {
        return $this->hasMany(FrequentlyAskedQuestion::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function category_images(){
        return $this->hasMany(CategorySliderImages::class,'categorys_id');
    }
}
