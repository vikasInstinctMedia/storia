<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class VerifyRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if($role == 'admin') {  
            $roleId = Role::ADMIN;
        } else if($role == 'branch_admin') {
            $roleId = Role::BRANCH_ADMIN;
        }

        if(auth()->user()->role_id != $roleId)
        { 
            return redirect('login');
        }

        return $next($request);
    }
}
