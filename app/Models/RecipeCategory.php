<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeCategory extends Model
{
    
    protected $guarded = ['id'];
    // Relationships

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
