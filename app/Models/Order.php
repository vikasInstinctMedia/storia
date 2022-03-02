<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    // Order Status
    const PENDING = "pending";
    const PROCESSING = "processing";
    const COMPLETED = "completed";
    const DECLINED = "declined";
    const DELIVERY = "on delivery";
    const CANCELLED = 'cancelled';

    // Payment Methods

    const PAYMENT_STATUS = [
        'cod'      => "Cash On Delivery",
        'razorpay' => "UPI/Online"
    ];



	use SoftDeletes;
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $dates = ['created_at'];

    // Relationship
    public function user()
    {
       return $this->belongsTo(User::class);
    }

    public function billing_address()
    {
       return $this->belongsTo(Address::class,'billing_address_id');
    }

    public function shipping_address_data()
    {
       return $this->belongsTo(Address::class,'shipping_address_id');
    }


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getBranchNameAttribute()
    {
        return $this->branch() ? $this->branch()->name : '';
    }

    // Attribute
    public function getProductsAttribute()
    {
        // dd(unserialize($this->cart));
        return unserialize($this->cart)['items'];
    }

    public function getCartDetailsAttribute()
    {
        // dd(unserialize($this->cart));
        return unserialize($this->cart);
    }

    public function getPaymentMethodTitleAttribute()
    {
        return self::PAYMENT_STATUS[$this->method];
    }
}
