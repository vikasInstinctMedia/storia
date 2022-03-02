<?php

namespace App\Http\Controllers\Front;
use App\Classes\GeniusMailer;
use App\Models\Order;
use App\Models\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Config;

class PaymentController extends Controller
{

     public function paycancle()
     {
       
         return redirect()->route('front.checkout')->with('unsuccess','Payment Cancelled.');
     }

     public function payreturn()
     {

        if(Session::has('tempcart'))
        {
            $oldCart = Session::get('tempcart');
            $tempcart = $oldCart;
            $order = Session::get('temporder');
            $order = Order::where('id', $order->id)->firstOrFail();
        }
        else
        {
            $tempcart = '';
            return redirect()->back();
        }
        //print_r(Session::all());die;
        return view('front.success',compact('tempcart','order'));
     }

}
