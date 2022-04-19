<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    // use HasFactory;
    protected $guarded = ['id'];

    public function tags(){
        return $this->hasMany(BlogsTags::class,'blog_id')->with('tags');
    }
}
