<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySliderImages extends Model
{
    use HasFactory;
    protected $table = 'category_slider_images';
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class,'categorys_id');
    }
}
