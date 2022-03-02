<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Validator;
use App\Models\Review;

class RegisterController extends Controller
{

	public function showRegisterForm()
    {

      return view('user.register');
    }


    public function register(Request $request)
    {

        $rules = [
        		'name'   => 'required',
		        'email'   => 'required|email|unique:users',
		        'password' => 'required'
                ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        $user = new User;
        $input = $request->all();
        $input['password'] = bcrypt($request['password']);

		    $user->fill($input)->save();

        Auth::guard('web')->login($user);
        return response()->json(1);
       // return response()->json('You are register Successfully..');
    }

    public function reviewAdd(Request $request){
        $review=new Review();
        $review->product_id=$request->product_id;
        $review->user_id=$request->user_id;
        $review->author=$request->author;
        $review->comment=$request->comment;
        $review->email=$request->author;
        $review->website=$request->author;
        $review->status="0";
        $review->save();
        return back();
    }

}
