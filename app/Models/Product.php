<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    // Relationships
    
    public function seo()
    {
        return $this->hasOne(Seo::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    

    // One product may fall under different categories
    public function categories()
    {
        return $this->hasMany(ProductCategory::class );
    }

    public function packs()
    {
        return $this->hasMany(ProductPackMap::class)->select('product_pack_maps.*')->join('packs', 'product_pack_maps.pack_id', 'packs.id')->orderBy('packs.quantity');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function includedProducts()
    {
        return $this->hasMany(AssortedProduct::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    // Attribute
    public function getBasePackPriceAttribute()
    {
        if($this->type == 'assorted') {
            return $this->price;
        }
        
        $minQty = $this->packs->min('details.quantity');
        $discount = $this->packs->where('details.quantity', $minQty)->first()->discount;
        
        if($discount) {
            return ($minQty * $this->price) - $discount;
        }
        return ($minQty * $this->price);
    }

    public function getBasePackPriceWithoutDiscountAttribute()
    {
        if($this->type == 'assorted') {
            return $this->price;
        }
        return $this->packs->min('details.quantity') * $this->price;
    }

    public function getBasePackAttribute()
    {
        return $this->packs->sortBy(function($query) {
            return $query->details->quantity;
        })->first();
    }

    
    // Methods
    public static function filterProducts($collection)
    {
        return $collection;
    }

    public function showName() {
        
        $name = mb_strlen($this->name,'utf-8') > 55 ? mb_substr($this->name,0,55,'utf-8').'...' : $this->name;
        return $name;
    }
    

    
    
}
