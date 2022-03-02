<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory;
use Session;

class ProductPackMap extends Model
{
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with = ['details'];

    public function details()
    {
        return $this->belongsTo(Pack::class, 'pack_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getIsProductInStockAttribute()
    {
        if(Session::has('branch_id')) 
        {
            if($this->inventory->first()->quantity < 1) {
                return false;
            }
        }
        return true;
    }

    public function inventory() 
    {
        $branchId = Session::has('branch_id') ? Session::get('branch_id') : 0 ;

        return $this->hasMany(Inventory::class)->where( 'branch_id', $branchId );
    }

}
