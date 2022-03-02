<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $guarded = ['id'];


     //  Relationships

     public function sku()
     {
        return $this->belongsTo(ProductPackMap::class, 'product_pack_map_id');
     }

     public function branch()
     {
        return $this->belongsTo(Branch::class);
     }
}
