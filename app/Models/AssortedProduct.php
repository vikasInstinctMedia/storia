<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssortedProduct extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function details()
    {
        return $this->belongsTo(Product::class, 'included_product_id');
    }
}
