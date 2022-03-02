<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Session;
use App\Traits\CartTrait;
use App\Notifications\OrderPlacedNotification;

use DrewM\MailChimp\MailChimp;

use Illuminate\Support\Facades\Http;
use App\Helpers\SmsAPIHelper;
use App\Jobs\SendMail;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use Mail;


class TestController extends Controller
{
    use CartTrait;

    function __construct()
    {
        if (config('app.env') === 'production') {
            dd('');
        }
    }

    public function add()
    {
        $product = Product::where("id", 1)->first();

        $this->addToCart([
            'id'    => $product->id,
            'name'  => $product->name,
            'price' => $product->price,
            'slug'  => $product->slug,
            'thumbnail_image' => $product->thumbnail_image,
            'quantity' => 1,
        ]);
        
        return back()->with('message', 'set');
    }

    public function show()
    {
        dd($this->getCartData());
    }
    

    public function remove()
    {
        Session::forget('cart');
    }


    public function testEmailMailchimp()
    {
        $key = config('newsletter.apiKey');
        $mailDrillKey = 'djxby38q9MmZ2PnTAEZGfQ';

        $mailChimp = new MailChimp($key);
        dump($mailChimp);

        
        $message = [
            "from_email" => "hello@example.com",
            "subject" => "Hello world",
            "text" => "Welcome to Mailchimp Transactional!",
            "to" => [
                [
                    "email" => "aakashchavan2233@gmail.com",
                    "type" => "to"
                ]
            ]
        ];


        // $result = $mailChimp->post('messages', $message);

        $endpoint = "https://mandrillapp.com/api/1.0/messages/send";
        $result = Http::withHeaders([
            'key' => $key
        ])
        ->post($endpoint,[ 'key' => $mailDrillKey, 'message' => $message ]);

        dump($result->status());
        dump($result->body());
        dd($result);
        dd(config('newsletter.apiKey'));
        // dd($mailChimp);
    }

    
    public function testInstagram()
    {

        //test sms alert api
        $order = Order::first();
        dd($order);
        //test

        (new SmsAPIHelper)->send('8898394690', SmsAPIHelper::ORDER_PLACED, [
            'name' => $order->customer_name,
            'order_number' => $order->order_number
        ]);

	    $url = sprintf('https://www.instagram.com/%s/media','storiafoods');
        $response = Http::get($url);
        $items = json_decode((string) $response->getBody(), true);
        dd($items);
    }

    public function testEmail()
    {
        $order = Order::first();
        // dd($order->products);
        // return view('email.order_placed', [ 'order' => $order ]);
        // return view('email.order_placed');
        $user = User::where('id', 3)->firstOrFail();
        // dd($user);
        // SendMail::dispatchSync(new OrderPlacedMail(), ['email' => 'aakashchavan2233@gmail.com']);
        dispatch_sync(new SendMail(new OrderPlacedMail($order),['email' => 'aakashchavan2233@gmail.com']));

        // OrderPlacedMail::dispatchSync();

    
        // dump($order->created_at->format('F d,Y'));
        // dd($order);

        Mail::to('aakashchavan2233@gmail.com')->queue(new OrderPlacedMail($order));

        // $user->notify(new OrderPlacedNotification());
    }


}
