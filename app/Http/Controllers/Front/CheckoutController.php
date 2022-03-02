<?php

namespace App\Http\Controllers\Front;

use App\Helpers\ShippingAPIHelper;
use App\Http\Controllers\Controller;
use App\Models\BranchDeliverablePincode;
use App\Models\Cart;
use App\Models\Order;
use App\Traits\CheckoutUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use App\Http\Requests\User\OrderCreateRequest;
use App\Models\Address;
use App\Mail\OrderPlacedMail;
use Mail;
use Auth;


use App\Helpers\SmsAPIHelper;

class CheckoutController extends Controller
{
    use CheckoutUtility;

    public function checkout()
    {
        // dd('test');
        // abort_if(!Auth::user(), 404 );

        if (!Session::has('cart')) {
            return redirect()->route('cart.page')->with('success', "You don't have any product to checkout.");
        }
        $user_address = [];
        if(isset(Auth::user()->id)){
           $user_address = Address::where('user_id',Auth::user()->id)->get();
        }
        // echo '<pre>';
        // print_r($user_address->toArray());
        // exit;
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $products = $cart->items;

        $total = $cart->sub_total;

        $states = BranchDeliverablePincode::states();
        $cities = BranchDeliverablePincode::cities();

        return view('front.checkout', ['products' => $cart->items, 'totalPrice' => $total, 'totalQty' => $cart->totalQty, 'states' => $states, 'cities' => $cities,'user_address'=>$user_address ]);
    }


    public function loadpayment($slug1, $slug2)
    {
        $payment = $slug1;
        $pay_id = $slug2;
        $gateway = '';
        if($payment == 'cod'){
            $cod_charges = 30;
        }else{
            $cod_charges = 0;
        }
        $cart_data = Session::get('cart');
        $cart_data['cod_charge'] = $cod_charges;
        Session::put('cart', $cart_data);

        return view('load.payment', compact('payment', 'pay_id', 'gateway'));
    }

    public function cashondelivery(Request $request)
    {
        $errors = $this->validateOrder($request->all(), Session::get('cart'));

        // exit;
        // $order = Order::latest()->first();
        // dd($request->all());

        if (count($errors)) {
            return back()->with('unsuccess', $errors[0]);
        }

        // validating if the
        if (!Session::has('cart')) {
            return redirect()->route('cart.page')->with('success', "You don't have any product to checkout.");
        }

        $oldCart = Session::get('cart');

        // get Branch ID
        $branch   = BranchDeliverablePincode::where('pincode', $request->zip)->firstOrFail()->branch;
        $branchId = $branch->id;

        //$cart = new Cart($oldCart);
        $cart = $oldCart;


        if($cart['cod_charge'] != 0){
            $cart['total'] = $cart['total'] + $cart['cod_charge'];
        }


        if(Auth::user()) {
            Auth::user()->cart()->updateOrCreate(['user_id' => Auth::user()->id ],['cart_data' => json_encode($cart)]);
        }

        $ship_to_diff_add = $request->get('ship_to_diff_add');

        $add_id = $request->get('add_id');

        if($add_id != '')
        {
            $billing_address_id = $add_id;
            $shipping_address_id = $add_id;
        }else{

        if($ship_to_diff_add != NULL){

            $billing_address['name'] =  $request->get('firstname') . ' ' . $request->get('lastname');
            $billing_address['email'] =  $request->get('email');
            $billing_address['phone'] = $request->get('phone');
            $billing_address['address'] = $request->get('address');
            $billing_address['country'] = $request->get('customer_country');
            $billing_address['city'] = $request->get('city');
            $billing_address['zip'] = $request->get('zip');
            $billing_address['user_id'] = $request->get('user_id');
            $billing_address['state'] = $request->get('customer_state');

            $billing_address_id = $this->add_address_to_database($billing_address);

            $shipping_address['name'] =   $request->get('shipping_firstname') . ' ' . $request->get('shipping_lastname');
            $shipping_address['email'] =  $request->get('shipping_email');
            $shipping_address['phone'] = $request->get('shipping_phone');
            $shipping_address['address'] = $request->get('shipping_address');
            $shipping_address['country'] = $request->get('shipping_country');
            $shipping_address['city'] = $request->get('shipping_city');
            $shipping_address['zip'] = $request->get('shipping_zip');
            $shipping_address['user_id'] = $request->get('user_id');
            $shipping_address['state'] = $request->get('shipping_state');

            $shipping_address_id = $this->add_address_to_database($shipping_address);

        }else{
            $billing_address['name'] =  $request->get('firstname') . ' ' . $request->get('lastname');
            $billing_address['email'] =  $request->get('email');
            $billing_address['phone'] = $request->get('phone');
            $billing_address['address'] = $request->get('address');
            $billing_address['country'] = $request->get('customer_country');
            $billing_address['city'] = $request->get('city');
            $billing_address['zip'] = $request->get('zip');
            $billing_address['user_id'] = $request->get('user_id');
            $billing_address['state'] = $request->get('customer_state');

            $billing_address_id = $this->add_address_to_database($billing_address);
            $shipping_address_id = $billing_address_id;
        }

        }

        $get_billing_address_data = Address::where('id',$billing_address_id)->first();
        $get_shipping_address_data = Address::where('id',$shipping_address_id)->first();

        // dd($billing_address_id);

        // Generate order number
        $orderNumber = $branch->prefix . Str::random(4) . time();


        $order = new Order;
        //$success_url = action('Front\PaymentController@payreturn');
        $item_name = "Storia Order";
        $item_number = Str::random(4) . time();
        $order['user_id'] = $request->get('user_id');
        $order['branch_id'] = $branchId;
        // $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
        $order['cart'] = (serialize($cart));
        $order['totalQty'] = $request->get('totalQty');
        // $order['pay_amount'] = round($request->get('total'), 2);
        $order['pay_amount'] = round($cart['total'], 2);
        $order['method'] = "cod";
        $order['customer_email'] = $get_billing_address_data->email;
        $order['customer_name'] = $get_billing_address_data->name;
        $order['customer_phone'] = $get_billing_address_data->phone;
        $order['order_number'] = $orderNumber;
        $order['customer_address'] = $get_billing_address_data->address;
        $order['customer_country'] = $get_billing_address_data->country;
        $order['customer_state']    = ucwords($get_billing_address_data->state);
        $order['customer_city'] = $get_billing_address_data->city;
        $order['customer_zip'] = $get_billing_address_data->zip;
        $order['shipping_email'] = $get_shipping_address_data->email;
        $order['shipping_name'] = $get_shipping_address_data->name;
        $order['shipping_phone'] = $get_shipping_address_data->phone;
        $order['shipping_address'] = $get_shipping_address_data->address;
        $order['shipping_country'] = $get_shipping_address_data->country;
        $order['shipping_city'] = $get_shipping_address_data->city;
        $order['shipping_zip'] = $get_shipping_address_data->zip;
        $order['order_note'] = $request->get('order_notes');
        $order['gender'] = $request->gender != '' ? $request->gender : NULL;
        $order['dob'] = $request->dob;
        $order['billing_address_id'] = $billing_address_id;
        $order['shipping_address_id'] = $shipping_address_id;
        $order['payment_status'] = "Pending";
        $order->save();

        $order_id = $order->id;


        $obj = new ShippingAPIHelper();
        $obj->createTrackingRequest($order);

        // Reduce the quantity as per the order
        $this->updateInventoryAfterOrder($order);

        Session::put('temporder', $order);
        Session::put('tempcart', $cart);

        Session::forget('cart');

        Session::forget('already');

        // Sending mail
        Mail::to($order->customer_email)->queue(new OrderPlacedMail($order));

        // Sending SMS
        (new SmsAPIHelper)->send($order->customer_phone, SmsAPIHelper::ORDER_PLACED, [
            'name' => $order->customer_name,
            'order_number' => $order->order_number
        ]);

        //Sending Email To Admin
        return redirect()->route('payment.return');
    }

}
