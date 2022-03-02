<?php

namespace App\Http\Controllers\Front;


use App\Helpers\ShippingAPIHelper;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Classes\GeniusMailer;
use App\Models\Cart;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\BranchDeliverablePincode;
use App\Traits\CheckoutUtility;
use App\Http\Requests\User\OrderCreateRequest;
use App\Mail\OrderPlacedMail;
use Mail;
use App\Helpers\SmsAPIHelper;
use App\Models\Address;

class RazorpayController extends Controller
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

    public function store(Request $request)
    {
        $errors = $this->validateOrder($request->all(), Session::get('cart'));
        // dd($request->all());

        if (count($errors)) {
            return back()->with('unsuccess', $errors[0]);
        }


        if (!Session::has('cart')) {
            return redirect()->route('cart.page')->with('success', "You don't have any product to checkout.");
        }

        // get Banch ID
        $branch = BranchDeliverablePincode::where('pincode', $request->zip)->firstOrFail()->branch;
        $branchId = $branch->id;
        $oldCart = Session::get('cart');
        //$cart = new Cart($oldCart);
        $cart = $oldCart;


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


        //$settings = Generalsetting::findOrFail(1);
        $order = new Order;
        //$success_url = action('Front\PaymentController@payreturn');
        $item_name = "Storia Order";
        $item_number =  $branch->prefix . Str::random(4) . time();
        $item_amount = $request->total;
        //$item_amount = 1;
        //$notify_url = action('Front\RazorpayController@razorCallback');
        $cancel_url = action('Front\PaymentController@paycancle');


        $orderData = [
            'receipt' => $item_number,
            'amount' => $item_amount * 100, // 2000 rupees in paise
            'currency' => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        // Generate order number
        // $orderNumber = $branch->prefix . Str::random(4) . time();

        $razorpayOrder = $this->api->order->create($orderData);

        $razorpayOrderId = $razorpayOrder['id'];

        session(['razorpay_order_id' => $razorpayOrderId]);

        $order['user_id'] = $request->user_id;
        $order['branch_id'] = $branchId;
        $order['cart'] = (serialize($cart));
        $order['totalQty'] = $request->totalQty;
        $order['pay_amount'] = round($item_amount, 2);
        $order['method'] = "razorpay";
        $order['customer_email'] = $get_billing_address_data->email;
        $order['customer_name'] = $get_billing_address_data->name;
        $order['customer_phone'] = $get_billing_address_data->phone;
        $order['order_number'] = $item_number;
        $order['customer_address'] = $get_billing_address_data->address;
        $order['customer_country'] = $get_billing_address_data->country;
        $order['customer_city'] = $get_billing_address_data->city;
        $order['customer_zip'] = $get_billing_address_data->zip;
        $order['customer_state']    = ucwords($get_billing_address_data->state);
        $order['shipping_email'] = $get_shipping_address_data->email;
        $order['shipping_name'] = $get_shipping_address_data->name;
        $order['shipping_phone'] = $get_shipping_address_data->phone;
        $order['shipping_address'] = $get_shipping_address_data->address;
        $order['shipping_country'] = $get_shipping_address_data->country;
        $order['shipping_city'] = $get_shipping_address_data->city;
        $order['shipping_zip'] = $get_shipping_address_data->zip;
        $order['order_note'] = $request->order_notes;
        $order['billing_address_id'] = $billing_address_id;
        $order['shipping_address_id'] = $shipping_address_id;
        $order['gender'] = $request->gender != '' ? $request->gender : NULL;
        $order['dob'] = $request->dob;
        $order['payment_status'] = "Pending";
        $order->save();


        Session::put('tempcart', $cart);
        Session::forget('cart');


        $displayAmount = $amount = $orderData['amount'];


        $checkout = 'automatic';

        if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true)) {
            $checkout = $_GET['checkout'];
        }

        $data = [
            "key" => $this->keyId,
            "amount" => $amount,
            "name" => $item_name,
            "description" => $item_name,
            "prefill" => [
                "name" => $request->firstname . '' . $request->lastname,
                "email" => $request->email,
                "contact" => $request->phone,
            ],
            "notes" => [
                "address" => $request->address,
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
        return view('front.razorpay-checkout', compact('data', 'json'));

    }

    public function razorCallback()
    {

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
            $order = Order::where('order_number', $order_id)->first();

            if (isset($order)) {
                $data['txnid'] = $transaction_id;
                $data['payment_status'] = 'Completed';

                $order->update($data);

                // @todo check the process
                $this->updateInventoryAfterOrder($order);
                // dd('exit');

                $obj = new ShippingAPIHelper();
                $obj->createTrackingRequest($order);


                // Sending mail
                Mail::to($order->customer_email)->queue(new OrderPlacedMail($order));


                // Sending SMS
                (new SmsAPIHelper)->send($order->customer_phone, SmsAPIHelper::ORDER_PLACED, [
                    'name' => $order->customer_name,
                    'order_number' => $order->order_number
                ]);

                Session::put('temporder', $order);

            }
            return redirect()->route('payment.return');

        } else {

            return redirect(route('front.checkout'));
        }

    }


}
