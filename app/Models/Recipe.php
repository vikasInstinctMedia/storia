<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $guarded = ['id'];


    // Relationships
    public function category()
    {
        return $this->belongsTo(RecipeCategory::class, 'recipe_category_id');
    }

    public function getShortDescriptionAttribute()
    {   
        return \Str::words(html_entity_decode($this->description), 5);
    }
}
