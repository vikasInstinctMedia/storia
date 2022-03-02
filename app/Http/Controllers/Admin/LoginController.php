<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use File;
use DB;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ( ! Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password,'status' => 1], $request->get('remember'))) {
            return back()->withError("email or password is wrong");
        }

        if (Auth::viaRemember()) {
            return response()->json([
                'success'  => 1
            ]);
        }
        // dd(Auth::guard('admin')->user());
        if(Auth::guard('admin')->user()->branch_id) {
            return redirect()->route('admin.cfa.dashboard')->with('message', 'Welcome');
        }

        return redirect()->route('admin.dashboard')->with('message', 'Welcome');
    }

    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.dashboard');
    }
}
