<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogsTags extends Model
{
    use HasFactory;
    protected $table="blogs_tags";

    public function tags(){
        return $this->belongsTo(Tags::class,'tag_id');
    }
}
