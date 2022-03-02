<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $guarded = ['id'];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function roleIs($role)
    {
        if($role == 'admin' && $this->role_id == 1) return true;
        else if( $role == 'branch_admin' && $this->role_id == 2 ) return true;

        return false;
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }
}
