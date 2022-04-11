<?php

namespace App\Http\Controllers\Front;

use App\Helpers\ShippingAPIHelper;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\BranchDeliverablePincode;
use App\Models\Order;
use App\Models\ProductPackMap;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use App\Traits\CheckoutUtility;
use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Razorpay\Api\Api;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{

    use CheckoutUtility;

    public function __construct()
    {

        // $rdata = Generalsetting::findOrFail(1);

        if (config('app.env') === 'production') {
            $this->keyId        = config('payment.razorpay.live_key');
            $this->keySecret    = config('payment.razorpay.live_secret');
        } else {
            $this->keyId        = config('payment.razorpay.test_key');
            $this->keySecret    = config('payment.razorpay.test_secret');
        }

        // $this->keyId = 'rzp_test_zInteAXE3hxj0M';
        // $this->keySecret = 'n5jdpm3ysH0wgvL4UItnBn3J';
        $this->displayCurrency = 'INR';

        $this->api = new Api($this->keyId, $this->keySecret);
    }
    public function index()
    {
        $all_subs = Subscription::with(['category','subscription_type','product','pack'])->get();
        return view('front.subscription',compact('all_subs'));
    }

    public function payment(Request $request){
        $req_data = $request->input();
        $sub_id = isset($req_data['sub_id']) ? $req_data['sub_id'] : '';
        $full_name = isset($req_data['full_name']) ? $req_data['full_name'] : '';
        $email = isset($req_data['email']) ? $req_data['email'] : '';
        $mobile_no = isset($req_data['mobile_no']) ? $req_data['mobile_no'] : '';
        $address = isset($req_data['address']) ? $req_data['address'] : '';
        $pay_type = isset($req_data['pay_type']) ? $req_data['pay_type'] : 1;
        $city = isset($req_data['city']) ? $req_data['city'] : '';
        $state = isset($req_data['state']) ? $req_data['state'] : '';
        $country = isset($req_data['country']) ? $req_data['country'] : '';
        $zip = isset($req_data['zip']) ? $req_data['zip'] : '';
        $auto_pay = isset($req_data['auto_pay']) ? $req_data['auto_pay'] : '2';
        $for_how_many = isset($req_data['for_how_many']) ? $req_data['for_how_many'] : 12;

        if($sub_id == ''){
            return back()->with('message', 'Something Went Wrong');
        }

        $subscription_data = Subscription::with(['category','subscription_type','product','pack'])->where('id',$sub_id)->first();

        if(empty($subscription_data)){
            return back()->with('message', 'Something Went Wrong');
        }

        $get_user_sub = UserSubscription::where('subscription_id',$sub_id)->where('users_id',Auth::user()->id)->where('status',1)->first();

        if(!empty($get_user_sub)){
            return back()->with('message', 'You Have Already Subscribed');
        }

        $item_number = $this->generate_receipt_id();
        $item_amount = $subscription_data->price;
        // exit;
        $orderData = [
            'receipt' => $item_number,
            'amount' => $item_amount * 100, // 2000 rupees in paise
            'currency' => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        // Generate order number
        // $orderNumber = $branch->prefix . Str::random(4) . time();

        if($auto_pay == 2){
        $razorpayOrder = $this->api->order->create($orderData);

        $razorpayOrderId = $razorpayOrder['id'];
        session(['razorpay_order_id' => $razorpayOrderId]);
        }
        $add_address = new Address();
        $add_address->name = $full_name;
        $add_address->email = $email;
        $add_address->country = $country;
        $add_address->address = $address;
        $add_address->city = $city;
        $add_address->zip = $zip;
        $add_address->user_id = Auth::user()->id;
        $add_address->phone = $mobile_no;
        $add_address->state = $state;
        $add_address->save();

        if($pay_type == 1){
            $rem = $for_how_many;
        }else{

            if($subscription_data->subscription_types_id == 1){
                $rem = $for_how_many * 4;
            }else{
                $rem = $for_how_many;
            }
         }

        $new_sub = new UserSubscription();
        $new_sub->subscription_id = $subscription_data->id;
        $new_sub->users_id = Auth::user()->id;
        $new_sub->full_name = $full_name;
        $new_sub->email = $email;
        $new_sub->address = $address;
        $new_sub->pay_type = $pay_type;
        $new_sub->for_how_many = $for_how_many;
        $new_sub->remaining_count = $rem;
        $new_sub->mobile_no = $mobile_no;
        $new_sub->city = $city;
        $new_sub->state = $state;
        $new_sub->country = $country;
        $new_sub->zip = $zip;
        $new_sub->addresses_id = $add_address->id;
        $new_sub->auto_pay = $auto_pay;
        // $new_sub->pay_type = '1';
        $new_sub->price = $subscription_data->price;
        $new_sub->receipt_id = $item_number;

        if($auto_pay == 2){
            $new_sub->status = 2;
            $new_sub->payment_status = 'Pending';
        }else{
            $new_sub->status = 1;
            $new_sub->payment_status = 'Completed';
        }
        $new_sub->save();
        $hour = date('H')+2;
        $start_at_time = strtotime(date('Y-m-d '.$hour.':i:s'));

        if($auto_pay == 1){

            if($pay_type == 1){
                $plan_string = 'weekly';
                $plan_price = $subscription_data->price;
            }else{
                $plan_string = 'monthly';
                if($subscription_data->subscription_types_id == 1){
                    $plan_price = $subscription_data->price * 4;
                }else{
                    $plan_price = $subscription_data->price;
                }
             }
            $api = new Api($this->keyId, $this->keySecret);
            $response1 = $api->plan->create(array('period' => $plan_string,
             'interval' => $for_how_many,
             'item' => array('name' => $subscription_data->title,
                            'description' => $subscription_data->title,
                            'amount' => $plan_price.'00',
                            'currency' => 'INR'),
            'notes'=> array('key1'=> 'value1',
                            'key2'=> 'value1')
            ));


            $api = new Api($this->keyId, $this->keySecret);

           $response =  $api->subscription->create(array('plan_id' => $response1['id'],
                                             'customer_notify' => 1,
                                             'quantity'=>1,
                                             'total_count' => $for_how_many,
                                             'start_at' => $start_at_time,
                                            //  "callback_url"=> route('user-dashboard'),
                                            //  "callback_method"=> "get",
                                            //  'addons' => array(array('item' => array('name' => 'Delivery charges',
                                            //                                          'amount' => 30000,
                                            //                                          'currency' => 'INR'))),
                                            //  'notes'=> array('key1'=> 'value3',
                                            //                  'key2'=> 'value2')
                                            ));
        $user_sub_id = $new_sub->id;

         $razorpay_sub_id = $response['id'];

         $user_sub_data = UserSubscription::where('id',$user_sub_id)->first();
         $user_sub_data->razorpay_sub_id = $razorpay_sub_id;
         $user_sub_data->save();

        //  return Redirect::to($response['short_url']);
        session(['short_url' => $response['short_url']]);
        $order = $user_sub_data;
        return view('front.success-subscription', compact('order'));
        // echo "<script>window.open('".$response['short_url']."', '_blank')</script>";
                                        // return;
        }
        session(['short_url' => '']);
        $displayAmount = $amount = $subscription_data->price;

        $checkout = 'automatic';

        if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true)) {
            $checkout = $_GET['checkout'];
        }

        $data = [
            "key" => $this->keyId,
            "amount" => $amount,
            "name" => $subscription_data->title,
            "description" => $subscription_data->title,
            "prefill" => [
                "name" => $full_name,
                "email" => $email,
                "contact" => $mobile_no,
            ],
            "notes" => [
                "address" => $address,
                "merchant_order_id" => $item_number,
            ],
            "theme" => [
                "color" => "#0f914f"
            ],
            "order_id" => $razorpayOrderId,
        ];

        //print_r($data); die;
        $json = json_encode($data);
        //print_r($json); die;
        return view('front.razorpay-checkout-subscription', compact('data', 'json'));

    }

    public function delete_unpaid_subscription(){
        $get_subs = UserSubscription::whereNotNull('razorpay_sub_id')->get();
        $api = new Api($this->keyId, $this->keySecret);
        foreach ($get_subs as $key => $value) {

            $response =  $api->subscription->fetch($value->razorpay_sub_id);
            if($response->payment_method == ''){
                UserSubscription::where('id', $value->id)->delete();
            }
        }
    }

    public function razorCallback(){

        // echo "DFsdf"; die;
        //print_r($_POST); die;
        $success = true;

        $error = "Payment Failed";

        if (empty($_POST['razorpay_payment_id']) === false) {

            try {
                $attributes = array(
                    'razorpay_order_id' => session('razorpay_order_id'),
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );

                $this->api->utility->verifyPaymentSignature($attributes);
            } catch (SignatureVerificationError $e) {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }

        if ($success === true) {

            $razorpayOrder = $this->api->order->fetch(session('razorpay_order_id'));

            $order_id = $razorpayOrder['receipt'];
            $transaction_id = $_POST['razorpay_payment_id'];

            $order = UserSubscription::where('receipt_id', $order_id)->first();

            if (isset($order)) {
                $order->order_id = $transaction_id;
                $order->payment_status = 'Completed';
                $order->status = 1;

                $order->save();

                // @todo check the process
                // $this->updateInventoryAfterOrder($order);
                // dd('exit');

                // $obj = new ShippingAPIHelper();
                // $obj->createTrackingRequest($order);


                // Sending mail
                // Mail::to($order->customer_email)->queue(new OrderPlacedMail($order));


                // Sending SMS
                // (new SmsAPIHelper)->send($order->customer_phone, SmsAPIHelper::ORDER_PLACED, [
                //     'name' => $order->customer_name,
                //     'order_number' => $order->order_number
                // ]);

                Session::put('temporder', $order);

            }
            return redirect()->route('subscription.return');

        } else {
            return redirect(route('subscription'));
        }

    }

    public function show_msg(){

        if(Session::has('temporder'))
        {
            $order = Session::get('temporder');
            $order = UserSubscription::with(['subscription'])->where('id', $order->id)->first();
            // echo '<pre>';
            // print_r($order);
            // exit;
        }
        else
        {
            $tempcart = '';
            return redirect()->back();
        }
        //print_r(Session::all());die;
        return view('front.success-subscription',compact('order'));

    }

    public function cancel_sub(Request $request){
        $req_data = $request->input();
        // print_r($req_data);
        $id = isset($req_data['sub_id']) ? $req_data['sub_id'] : '';

        if($id != ''){
            $get_user_sub = UserSubscription::where('id',$id)->first();

            if($get_user_sub->razorpay_sub_id != ''){
                $sub_id_latest = $get_user_sub->razorpay_sub_id;
                $api = new Api($this->keyId, $this->keySecret);
                $subdata = $api->subscription->fetch($sub_id_latest);
                if($subdata['status'] != 'expired'){
                $api->subscription->fetch($sub_id_latest)->pause(array('pause_at'=>'now'));
                }
            }
            // exit;
            $get_user_sub->status = 2;
            $get_user_sub->save();
            return back()->with('message', 'Subscription Canceled');
        }

        return back()->with('message', 'Something Went Wrong');

    }

    public function generate_receipt_id(){
        $get_last_bill = UserSubscription::latest('id')->first();

        if(isset($get_last_bill->id)){
            $last_id = $get_last_bill->receipt_id;
            $last_id_array = str_split($last_id,10);
            $new_id = $last_id_array[1]+1;
            $new_main_id = str_pad($new_id, 5, '0', STR_PAD_LEFT);
        }else{
            $new_main_id = '00001';
        }
        return '#STORIASUB'.$new_main_id;
    }

    public function generate_orders(){
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes

        $get_all_user_subscription = UserSubscription::with(['subscription'])
                                                      ->where('payment_status','Completed')
                                                      ->where('status',1)
                                                      ->get();
        // $payment_link = '';
        // $payment_txn_id = '';
        // echo '<pre>';
        // print_r($get_all_user_subscription->toArray());
        // exit;
        // $cart = Session::get('cart');
        // print_r($cart);
        // exit;
        $custom_cart = [];
        $order_ids = [];
        foreach ($get_all_user_subscription as $key => $value) {
            if($value->remaining_count == 0){
                continue;
            }
            $payment_link = '';
            $payment_txn_id = '';
            // echo $value->subscription->subscription_types_id;
            $get_last_order = Order::where('user_subscription_id',$value->id)
                                    ->where('subscription_order',1)
                                    ->orderBy('id','desc')
                                    ->first();

            $pack_maps_data = ProductPackMap::where('product_id',$value->subscription->products_id)
                                            ->where('pack_id',$value->subscription->packs_id)
                                            ->first();
            // print_r($pack_maps_data->toArray());
            // continue;

            $branch   = BranchDeliverablePincode::where('pincode', $value->zip)->firstOrFail()->branch;
            $branchId = $branch->id;
            // print_r($value->toArray());

           if(!empty($get_last_order))
           {
           $last_order_date = date('Y-m-d',strtotime($get_last_order->created_at));
           $current_date = date('Y-m-d');
           $now = time(); // or your date as well
           $your_date = strtotime($last_order_date);
           $datediff = $now - $your_date;

           $days_count = round($datediff / (60 * 60 * 24));
            // continue;
            if($value->subscription->subscription_types_id == 1){
                if($days_count >= 7){

                    if($value->auto_pay == 1){
                        $api = new Api($this->keyId, $this->keySecret);

                        $razor_sub_data = $api->subscription->fetch($value->razorpay_sub_id);
                        $payment_status = 'Completed';
                        // print_r($razor_sub_data);
                        if($razor_sub_data['payment_method'] == '' || $razor_sub_data['payment_method'] == null || $razor_sub_data['remaining_count'] == 0){
                            continue;
                        }
                    }elseif($value->auto_pay == 2){
                        if($value->pay_type == 2){
                            $get_cnt = Order::where('user_subscription_id',$value->id)
                            ->where('subscription_order',1)
                            ->orderBy('id','asc')
                            ->count();
                            $check_weeks = $get_cnt % 4;
                            if($get_cnt == 0){
                                $check_weeks == 1;
                            }
                            if($check_weeks == 0){
                                $api = new Api($this->keyId, $this->keySecret);

                                $payment_link_data = $api->paymentLink->create(array('amount'=>$value->price * 100 * 4,
                                'currency'=>'INR',
                                'accept_partial'=>true,
                                'first_min_partial_amount'=>$value->price * 100 * 4,
                                'description' => $value->subscription->title,
                                'customer' => array('name'=>$value->full_name,
                                                    'email' => $value->email,
                                                    'contact'=>$value->mobile_no),
                                                    'notify'=>array('sms'=>true,
                                                    'email'=>true),
                                'reminder_enable'=>true,
                                'notes'=>array('package'=> $value->subscription->title),
                                "callback_url"=> route('user.update_payment_status',$value->id),
                                "callback_method"=> "get",
                                                    ));
                                // print_r($payment_link_data);
                                $payment_link = $payment_link_data['short_url'];
                                $payment_txn_id = $payment_link_data['id'];
                                $payment_status = 'Pending';
                            }else{
                                $payment_link = '';
                                $payment_txn_id = '';
                                $payment_status = 'Pending';
                            }
                        }else{
                            $api = new Api($this->keyId, $this->keySecret);

                            $payment_link_data = $api->paymentLink->create(array('amount'=>$value->price * 100,
                            'currency'=>'INR',
                            'accept_partial'=>true,
                            'first_min_partial_amount'=>$value->price * 100,
                            'description' => $value->subscription->title,
                            'customer' => array('name'=>$value->full_name,
                                                'email' => $value->email,
                                                'contact'=>$value->mobile_no),
                                                'notify'=>array('sms'=>true,
                                                'email'=>true),
                            'reminder_enable'=>true,
                            'notes'=>array('package'=> $value->subscription->title),
                            "callback_url"=> route('user.update_payment_status',$value->id),
                            "callback_method"=> "get",
                                                ));
                            // print_r($payment_link_data);
                            $payment_link = $payment_link_data['short_url'];
                            $payment_txn_id = $payment_link_data['id'];
                            $payment_status = 'Pending';
                        }

                    }

                    $packPrice = $value->subscription->pack->quantity * $value->subscription->product->price - $pack_maps_data->discount;
                    $custom_cart['items'][0] = array(
                        'unique_id' => $value->subscription->product->id . $pack_maps_data->id . rand(10, 100),
                        'id'    => $value->subscription->product->id,
                        'name'  => $value->subscription->product->name .' '. $value->subscription->pack->title ,
                        'pack_name' => $value->subscription->pack->title,
                        'price' => $value->price,
                        'slug'  => $value->subscription->product->slug,
                        'thumbnail_image' => $value->subscription->product->banner_image,
                        'pack_id' => $pack_maps_data->id,
                        'quantity' => 1,
                        'product_total' => $value->price
                    );

                    $custom_cart['sub_total'] = $value->price;
                    if($value->price < 500){
                        $custom_cart['shipping_charge'] = 50;
                    }else{
                        $custom_cart['shipping_charge'] = 0;
                    }
                    $custom_cart['cod_charge'] = 0;
                    $custom_cart['total'] = $value->price + $custom_cart['shipping_charge'];
                    // print_r($custom_cart);
                    // exit;
                    $order_id = $this->create_order($value,$custom_cart,$branch,$payment_link,$payment_txn_id,$payment_status);
                    array_push($order_ids,$order_id);
                }
              }elseif($value->subscription->subscription_types_id == 2){
                if($days_count >= 30){

                    if($value->auto_pay == 1){
                        $api = new Api($this->keyId, $this->keySecret);

                        $razor_sub_data = $api->subscription->fetch($value->razorpay_sub_id);
                        // print_r($razor_sub_data);
                        $payment_status = 'Completed';
                        if($razor_sub_data['payment_method'] == '' || $razor_sub_data['payment_method'] == null || $razor_sub_data['remaining_count'] == 0){
                            continue;
                        }
                    }elseif($value->auto_pay == 2){
                        $api = new Api($this->keyId, $this->keySecret);

                        $payment_link_data = $api->paymentLink->create(array('amount'=>$value->price * 100,
                        'currency'=>'INR',
                        'accept_partial'=>true,
                        'first_min_partial_amount'=>$value->price * 100,
                        'description' => $value->subscription->title,
                        'customer' => array('name'=>$value->full_name,
                                            'email' => $value->email,
                                            'contact'=>$value->mobile_no),
                                            'notify'=>array('sms'=>true,
                                            'email'=>true),
                        'reminder_enable'=>true,
                        'notes'=>array('package'=> $value->subscription->title),
                        "callback_url"=> route('user.update_payment_status',$value->id),
                        "callback_method"=> "get",
                                            ));
                        // print_r($payment_link_data);
                        $payment_link = $payment_link_data['short_url'];
                        $payment_txn_id = $payment_link_data['id'];
                        $payment_status = 'Pending';
                    }


                    $packPrice = $value->subscription->pack->quantity * $value->subscription->product->price - $pack_maps_data->discount;
                    $custom_cart['items'][0] = array(
                        'unique_id' => $value->subscription->product->id . $pack_maps_data->id . rand(10, 100),
                        'id'    => $value->subscription->product->id,
                        'name'  => $value->subscription->product->name .' '. $value->subscription->pack->title ,
                        'pack_name' => $value->subscription->pack->title,
                        'price' => $value->price,
                        'slug'  => $value->subscription->product->slug,
                        'thumbnail_image' => $value->subscription->product->banner_image,
                        'pack_id' => $pack_maps_data->id,
                        'quantity' => 1,
                        'product_total' => $value->price
                    );

                    $custom_cart['sub_total'] = $value->price;
                    if($value->price < 500){
                        $custom_cart['shipping_charge'] = 50;
                    }else{
                        $custom_cart['shipping_charge'] = 0;
                    }
                    $custom_cart['cod_charge'] = 0;
                    $custom_cart['total'] = $value->price + $custom_cart['shipping_charge'];
                    // print_r($custom_cart);
                    // exit;
                    $order_id = $this->create_order($value,$custom_cart,$branch,$payment_link,$payment_txn_id,$payment_status);
                    array_push($order_ids,$order_id);
                }
              }
            }else{
                // echo '<pre>';
                if($value->auto_pay == 1){
                    $api = new Api($this->keyId, $this->keySecret);

                    $razor_sub_data = $api->subscription->fetch($value->razorpay_sub_id);
                    // print_r($razor_sub_data);
                    $payment_status = 'Completed';
                    if($razor_sub_data['payment_method'] == '' || $razor_sub_data['payment_method'] == null || $razor_sub_data['remaining_count'] == 0){
                        continue;
                    }
                  }elseif($value->auto_pay == 2){
                    $api = new Api($this->keyId, $this->keySecret);

                  $payment_link_data = $api->paymentLink->create(array('amount'=>$value->price * 100,
                                                    'currency'=>'INR',
                                                    'accept_partial'=>true,
                                                    'first_min_partial_amount'=>$value->price * 100,
                                                    'description' => $value->subscription->title,
                                                    'customer' => array('name'=>$value->full_name,
                                                                        'email' => $value->email,
                                                                        'contact'=>$value->mobile_no),
                                                                        'notify'=>array('sms'=>true,
                                                                        'email'=>true),
                                                    'reminder_enable'=>true,
                                                    'notes'=>array('package'=> $value->subscription->title),
                                                    "callback_url"=> route('user.update_payment_status',$value->id),
                        "callback_method"=> "get",
                                                ));
                   // print_r($payment_link_data);
                   $payment_link = $payment_link_data['short_url'];
                   $payment_txn_id = $payment_link_data['id'];
                   $payment_status = 'Completed';
                }
                // continue;
                // continue;
                $packPrice = $value->subscription->pack->quantity * $value->subscription->product->price - $pack_maps_data->discount;
                $custom_cart['items'][0] = array(
                    'unique_id' => $value->subscription->product->id . $pack_maps_data->id . rand(10, 100),
                    'id'    => $value->subscription->product->id,
                    'name'  => $value->subscription->product->name .' '. $value->subscription->pack->title ,
                    'pack_name' => $value->subscription->pack->title,
                    'price' => $value->price,
                    'slug'  => $value->subscription->product->slug,
                    'thumbnail_image' => $value->subscription->product->banner_image,
                    'pack_id' => $pack_maps_data->id,
                    'quantity' => 1,
                    'product_total' => $value->price
                );

                $custom_cart['sub_total'] = $value->price;
                if($value->price < 500){
                    $custom_cart['shipping_charge'] = 50;
                }else{
                    $custom_cart['shipping_charge'] = 0;
                }
                $custom_cart['cod_charge'] = 0;
                $custom_cart['total'] = $value->price + $custom_cart['shipping_charge'];
                // print_r($custom_cart);
                // exit;
                $order_id = $this->create_order($value,$custom_cart,$branch,$payment_link,$payment_txn_id,$payment_status);
                array_push($order_ids,$order_id);
            }


        }

        // print_r($order_ids);
        if(!empty($order_ids)){
            // $num = 0;
            // foreach ($order_ids as $key => $value) {
            //     $this->create_payment_link($value,$order_ids,$num);
            // $num++;
            // }
            $save_ids = Setting::where('key','cron-user-orders')->first();
            $save_ids->value = json_encode($order_ids);
            $save_ids->save();

            // $this->create_payment_links_main();
        }
    }

    public function create_order($user_subscription,$custom_cart,$branch,$payment_link = '',$payment_txn_id = '',$payment_status = 'Pending'){

        $order = new Order;
        //$success_url = action('Front\PaymentController@payreturn');
        $item_name = "Storia Order";
        $item_number = Str::random(4) . time();
        $orderNumber = $branch->prefix . Str::random(4) . time();

        $order['user_id'] = $user_subscription->users_id;
        $order['branch_id'] = $branch->id;
        // $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
        $order['cart'] = (serialize($custom_cart));
        $order['totalQty'] = 1;
        // $order['pay_amount'] = round($request->get('total'), 2);
        $order['pay_amount'] = round($user_subscription->price, 2);
        $order['method'] = "razorpay";
        $order['customer_email'] = $user_subscription->email;
        $order['customer_name'] = $user_subscription->full_name;
        $order['customer_phone'] = $user_subscription->mobile_no;
        $order['order_number'] = $orderNumber;
        $order['customer_address'] = $user_subscription->address;
        $order['customer_country'] = $user_subscription->country;
        $order['customer_state']    = ucwords($user_subscription->state);
        $order['customer_city'] = $user_subscription->city;
        $order['customer_zip'] = $user_subscription->zip;
        $order['shipping_email'] = $user_subscription->email;
        $order['shipping_name'] = $user_subscription->full_name;
        $order['shipping_phone'] = $user_subscription->mobile_no;
        $order['shipping_address'] = $user_subscription->address;
        $order['shipping_country'] = $user_subscription->country;
        $order['shipping_city'] = $user_subscription->city;
        $order['shipping_zip'] = $user_subscription->zip;
        $order['order_note'] = 'Subscription Order';
        $order['gender'] =  NULL;
        $order['dob'] = NULL;
        $order['billing_address_id'] = $user_subscription->addresses_id;
        $order['shipping_address_id'] = $user_subscription->addresses_id;
        $order['payment_status'] = $payment_status;
        $order['subscription_order'] = 1;
        $order['user_subscription_id'] = $user_subscription->id;
        $order['razorpay_payment_link'] = $payment_link;
        $order['txnid'] = $payment_txn_id;
        $order->save();

        $get_user_sub = UserSubscription::where('id',$user_subscription->id)->first();
        $rem = $get_user_sub->remaining_count;
        $rem = $rem - 1;
        $get_user_sub->remaining_count = $rem;
        $get_user_sub->save();

        $order_id = $order->id;

        $obj = new ShippingAPIHelper();
        $obj->createTrackingRequest($order);
        $this->updateInventoryAfterOrder($order);

        return $order_id;

    }

    public function create_payment_links_main(){
        $save_ids = Setting::where('key','cron-user-orders')->first();
        $saved_ids = json_decode($save_ids->value,true);
        print_r($saved_ids);
        exit;
        if(!empty($saved_ids)){
            foreach($saved_ids as $value){
                $this->create_payment_link($value);
            }
        }
    }

    public function create_payment_link($order){

            $get_order_details = Order::where('id',$order)->first();
            $get_subscription_data = UserSubscription::with(['subscription'])->where('id',$get_order_details->user_subscription_id)->first();

            $get_setting_cron_data = Setting::where('key','cron-user-orders')->first();
            $get_ids = json_decode($get_setting_cron_data->value,true);

            if (($key = array_search($order, $get_ids)) !== false) {
                unset($get_ids[$key]);
            }

            $new_ids = json_encode($get_ids);
            $get_setting_cron_data->value = $get_ids;
            $get_setting_cron_data->save();
            return;
            }

      public function update_payment_status(Request $request){
        $req_data = $request->input();
        $razorpay_payment_link_id = $request->razorpay_payment_link_id;
        $get_order = Order::where('txnid',$razorpay_payment_link_id)->first();
        $get_order->payment_status = 'Completed';
        $get_order->save();
        // return Redirect::to();
        return redirect()->route('user-dashboard')->with('message', 'Payment Done');

    }
}
