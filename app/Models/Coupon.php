<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = ['valid_from', 'valid_till'];

    const TYPES = [
        'fixed'    => 'fixed',
        'percentage' => 'percentage',
    ];
}
