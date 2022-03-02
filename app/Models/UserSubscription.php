<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $fillable = ['order_id'];

    use HasFactory;
    protected $table="user_subscription";

    public function subscription(){
        return $this->belongsTo(Subscription::class,'subscription_id')->with(['category','subscription_type','product','pack']);
    }
}
