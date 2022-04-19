<?php


namespace App\Helpers;


use App\Models\BranchDeliverablePincode;
use App\Models\Order;
use App\Models\ProductPackMap;
use Cache;
use Exception;
use Illuminate\Support\Facades\Http;
use App\Traits\CheckoutUtility;
use Illuminate\Support\Facades\Log;

class ShippingAPIHelper
{
    use CheckoutUtility;

    private $hostUrl;
    private $headers;

    public function __construct()
    {
        $this->hostUrl = "https://api.nimbuspost.com/v1/";

        $this->headers = [
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->login(),
        ];

    }

    /*---------------- Login ---------------- */

    public function login()
    {
        // END POINT ===  users/login

        // 30 Minutes
        $seconds = 60 * 30;

        return Cache::remember('shipping_login_token', $seconds, function () {

            $endpoint = "users/login";

            $json_data = [
                "email" => config('shipping.nimbuspost.email'),
                "password" => config('shipping.nimbuspost.secret'),
            ];


            $response = Http::withOptions([
                'verify' => false
            ])->post($this->hostUrl . $endpoint, $json_data);

            $res = json_decode($response->body(), true);

            return $res['data'];  // token

        });
    }


    /*---------------- Create Tracking Request---------------- */

    public function createTrackingRequest(Order $order)
    {
        // END POINT ===  shipments

        // dd($this->headers);
        // echo '<pre>';
        // print_r($order);
        // echo '</pre>';
        try {
            $endpoint = "shipments";


            if ($order->method == "cod") {
                $orderType = "cod";
            } else {
                $orderType = "prepaid";
            }


            $cart = unserialize($order->cart);
            $carts = [];


            foreach ($cart['items'] as $key => $item) {
                $carts[$key]['name'] = $item['name'];
                $carts[$key]['qty'] = $item['quantity'];
                $carts[$key]['price'] = $item['price'];
                $carts[$key]['sku'] = ProductPackMap::find($item['pack_id'])->sku ?? "Not Found";
            }


//            $order->customer_zip
            $warehouseDetails = BranchDeliverablePincode::query()
                ->where('pincode', $order->customer_zip)
                ->with('branch')
                ->first();


//            dd($warehouseDetails->pincode);
            // dump('check');
            // dump($cart);
            // dump($carts );
            $packageDetails = $this->getConsignmentPackageDetails($cart);


            $orderDetails = [
                "order_number" => $order->order_number,
                "shipping_charges" => 0,
                "discount" => 0,
                "cod_charges" => 0,
                "payment_type" => $orderType,
                "order_amount" => $order->pay_amount,
                "package_weight" => $packageDetails['weight'], // grams // not in decimal
                "package_length" => (int)$packageDetails['length'], //cm
                "package_breadth" => (int)$packageDetails['breadth'],
                "package_height" => $packageDetails['height'],

                "consignee" => [
                    "name" => $order->customer_name,
                    "address" => $order->customer_address,
                    "address_2" => "",
                    "city" => $order->customer_city,

                    //@todo
                    // // Add State Name ....

                    "state" => $order->customer_state,

                    "pincode" => $order->customer_zip,
//                    "pincode" => "400001",
                    "phone" => $order->customer_phone
//                    "phone" => "9895956956"
                ],

                "pickup" => [

                    "warehouse_name" => $warehouseDetails->branch->name,

                    "name" => $warehouseDetails->branch->contact_person_name,
                    "address" =>  $warehouseDetails->branch->address,
                    "address_2" => $warehouseDetails->branch->address_two,
                    "city" => $warehouseDetails->branch->city,
                    "state" => $warehouseDetails->branch->state,
                    "pincode" => $warehouseDetails->branch->pincode,
                    "phone" => $warehouseDetails->branch->contact_person_phone,
                ],

                "order_items" => $carts

//                    [
//                        "name" => "Soap",
//                        "qty" => "1",
//                        "price" => "10",
//                        "sku" => "soap111",
//
//                    ],
//
//                    [
//                        "name" => "Shampoo",
//                        "qty" => "1",
//                        "price" => "10",
//                        "sku" => "shampoo111",
//                    ],

                ,

            ];

            // dd($orderDetails);

            $response = Http::withHeaders($this->headers)
                ->withOptions([
                    'verify' => false
                ])
                ->post($this->hostUrl . $endpoint, $orderDetails);


            $res = json_decode($response->body(), true);

            // echo '<pre>';
            // print_r($res);
            // echo '</pre>';
// exit;
            if ($res['status']) {
                $awb_number = $res['data']['awb_number'];
                $order->awb_number = $awb_number;
                $order->save();
                Log::info('Created Tracking Request');
            }

            else{
                info("Checkout Shipping == " . json_encode($orderDetails) . " - ". $res['message']);
                Log::info('Tracking Request create Failed');
            }
            // dd($res);
        //    dd($res);


        } catch (Exception $e) {
            Log::info('Tracking Request create Failed');
            info("Checkout Shipping == " . $e->getMessage());
        }
    }


    /*---------------- Track Order---------------- */

    public function trackOrder($awbNumber)
    {
        // END POINT ===  shipments/track/$awbNumber

        try {
            $endpoint = "shipments/track/$awbNumber";


            $response = Http::withHeaders($this->headers)
                ->get($this->hostUrl . $endpoint);

            $res = json_decode($response->body(), true);


            if ($res['status']) {
//                return collect($res['data']);

                // Converting History array to Collection

                $collect = collect($res['data']['history'])->map(function ($child) {
                    return (object)$child;
                });

                return ($collect);

            }

            return collect();


        } catch (Exception $e) {
            info("Tracking Shipping == " . $e->getMessage());
            return collect();
        }
    }


    /*---------------- Cancel Order---------------- */

    public function cancelOrder($awbNumber)
    {
        // END POINT ===  shipments

        // END POINT ===  shipments/cancel

        try {
            $endpoint = "shipments/cancel";


            $json_data = [
                "awb" => $awbNumber,
            ];

            $response = Http::withHeaders($this->headers)
                ->withOptions([
                    'verify' => false
                ])
                ->post($this->hostUrl . $endpoint, $json_data);


            $res = json_decode($response->body(), true);

            info(json_encode($res));

            return $res['status'];


        } catch (Exception $e) {
            info("Cancel Shipping == " . $e->getMessage());
            return false;
        }
    }
}
