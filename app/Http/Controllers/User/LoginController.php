<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
    }

    public function showLoginForm()
    {

      return view('user.login');
    }

    public function login(Request $request)
    {
      
        //--- Validation Section
        $rules = [
                  'email'   => 'required|email',
                  'password' => 'required'
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

      // Attempt to log the user in
      if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // if successful, then redirect to their intended location

          // Setting up cart if user has any data, or continue with session
          // if(!empty(Auth::user()->cart) && !Session::has('cart') ) {
            
          //   Session::put('cart', Auth::user()->cart->cart_data);
          // }

          // Login as User
          return response()->json(route('user-dashboard'));
      }

      // if unsuccessful, then redirect back to the login with the form data
      return response()->json(array('errors' => [ 0 => 'Credentials Doesn\'t Match !' ]));     
    }

    public function logout()
    {
        Session::forget('cart');
        Session::forget('temporder');
        Auth::guard('web')->logout();
        return redirect('/home');
    }

}
