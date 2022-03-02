<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table="subscription";

    public function category(){
        return $this->belongsTo(Category::class,'categorys_id');
    }

    public function subscription_type(){
        return $this->belongsTo(SubscriptionTypes::class,'subscription_types_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'products_id')->with(['packs']);
    }

    public function pack(){
        return $this->belongsTo(Pack::class,'packs_id');
    }
}
