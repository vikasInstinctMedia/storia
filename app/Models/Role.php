<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    const ADMIN        = 1;
    const BRANCH_ADMIN = 2;
}
