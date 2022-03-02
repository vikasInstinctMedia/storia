<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Session;
use Cart;
use App\Helpers\ShippingAPIHelper;

class TrackOrderController extends Controller
{
    public function index()
    {
        // Session::forget('order');
        return view('front.track_order'); 
    }


    public function track(Request $request)
    {
        // dd($request->all());

        $order = Order::where('awb_number', $request->tracking_number )->orWhere('order_number',$request->tracking_number )->first();

        if(! $order ) {
            Session::flash('no_order_found', true);
            return back()->with('error', "No order Found");
        }

        $trackingDataCollection = (new ShippingAPIHelper())->trackOrder($order->awb_number);


        $order->delivery_status = 'Not Found';
   
        if( $trackingDataCollection->isNotEmpty() ) {
            $order->delivery_status  = $trackingDataCollection->last()->message;
        }
        
        Session::flash('order', $order);

        return back();
    }

    public function cancelOrder(Request $request)
    {
        // dd($request->all());

        // @todo Check if order could be canceled 

        $order = Order::where('awb_number', $request->awb_number)->firstOrFail();

        // Cancel the order
        $status = (new ShippingAPIHelper())->cancelOrder($order->awb_number);

        if( ! $status) {
            return redirect('/')->with('error','Unable to cancel the order');
        }

        $order->status = 'cancelled';

        $order->save();

        return redirect('/')->with('message','Order Canceled Successfully');

    }

    public function webhookUpdate(Request $request) 
    {
        info('webhook');
        info($request->header('Authorization'));
        info($request->header());
        info($request->all());

        // $jsonPayload = '{ "awb_number": "4152912381315", "status": "in transit", "event_time": "2021-02-26 16:19:59", "location": "Delhi", "message": "Reached at nearest hub", "rto_awb": "" }';

    }


}
