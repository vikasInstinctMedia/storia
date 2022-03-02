<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = ['id'];


    //  Relationships

    public function pincodes()
    {
        return $this->hasMany(BranchDeliverablePincode::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }


    public function products()
    {
        return $this->inventories()->sku();
    }

}
