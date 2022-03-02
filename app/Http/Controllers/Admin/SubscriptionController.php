<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\ProductPackMap;
use App\Models\Subscription;
use App\Models\SubscriptionTypes;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Razorpay\Api\Api;

class SubscriptionController extends Controller
{

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
        $subscription = Subscription::with(['category','subscription_type','product','pack'])->get();
        return view('admin.subscription.index', compact('subscription'));
    }

    public function create()
    {
        $subscription_types = SubscriptionTypes::get();
        $category = Category::get();
        return view('admin.subscription.form',compact('subscription_types','category'));
    }

    public function store(Request $request)
    {
        $req_data = $request->input();

        $image_file = request()->file('thumbnail_image');
        if(!empty($image_file)){
            $image_name  = $image_file->hashName();
            $image_path  = 'subscriptions/';
            $image_file->store($image_path);
        }else{
            $image_name = '';
        }

        if($req_data['subscription_types_id'] == 1){
            $plan_type = 'weekly';
        }elseif($req_data['subscription_types_id'] == 2){
            $plan_type = 'monthly';
        }

        $api = new Api($this->keyId, $this->keySecret);
        $response = $api->plan->create(array('period' => $plan_type,
         'interval' => 12,
         'item' => array('name' => $req_data['title'],
                        'description' => $req_data['title'],
                        'amount' => $req_data['price'].'00',
                        'currency' => 'INR'),
        'notes'=> array('key1'=> 'value1',
                        'key2'=> 'value1')
        ));

        // print_r($response['id']);

        $new_sub = new Subscription();
        $new_sub->subscription_types_id = $req_data['subscription_types_id'];
        $new_sub->title = $req_data['title'];
        $new_sub->plan_id = $response['id'];
        $new_sub->categorys_id = $req_data['category_id'];
        $new_sub->products_id = $req_data['products_id'];
        $new_sub->packs_id = $req_data['packs_id'];
        $new_sub->price = $req_data['price'];
        $new_sub->mrp = $req_data['mrp'];
        $new_sub->thumbnail = 'subscriptions/'.$image_name;
        $new_sub->created_at = date('Y-m-d H:i:s');
        $new_sub->save();


        // $latest_id = $new_sub->id;
        // $get_latest
        // exit;

        return redirect()->route('admin.subscription')->with('message', 'Created');
    }

    public function edit($id)
    {
        $subscription = Subscription::where('id',$id)->first();
        $subscription_types = SubscriptionTypes::get();
        $category = Category::get();

        $category_id = $subscription->categorys_id;


      $category_2 = Category::where('id', $category_id)->active()->first();

      if($category_2) {

        $products = $category_2->products
                  ->load('product', 'product.packs', 'product.packs.details', 'product.packs.inventory')
                  ->pluck('product');
        $products = $products->where('is_active',1)->sortByDesc('is_featured');
        $data['category'] = $category_2;
        $products = $products->map(function ($product) {
                          $product->append(['base_pack_price', 'base_pack']);
                          return $product;
                        });
        $data['products'] = $products;

      }

    //   echo '<pre>';
    //   print_r($products->toArray());
    //   exit;

    $get_pro_packs = ProductPackMap::where('product_id',$subscription->products_id)->get();
      $action = 'edit';
        return view('admin.subscription.form', compact('subscription','subscription_types','category','products','get_pro_packs','action'));
    }

    public function update(Request $request)
    {
       $req_data = $request->input();
       $old_thumbnail = isset($req_data['old_thumbnail']) ? $req_data['old_thumbnail'] : '';
       $subscription_id = isset($req_data['subscription_id']) ? $req_data['subscription_id'] : '';

       if (request()->file('thumbnail_image') != null && !empty(request()->file('thumbnail_image'))) {
        $image_file = request()->file('thumbnail_image');
        $image_name  = $image_file->hashName();
        $image_path  = 'subscriptions/';
        $image_file->store($image_path);
        Storage::delete($old_thumbnail);
        }else{
            $image_name = $old_thumbnail ;
        }

        $get_sub_data = Subscription::where('id',$subscription_id)->first();
        $get_sub_data->subscription_types_id = $req_data['subscription_types_id'];
        $get_sub_data->title = $req_data['title'];
        $get_sub_data->categorys_id = $req_data['category_id'];
        $get_sub_data->products_id = $req_data['products_id'];
        $get_sub_data->packs_id = $req_data['packs_id'];
        $get_sub_data->price = $req_data['price'];
        $get_sub_data->mrp = $req_data['mrp'];
        $get_sub_data->thumbnail = 'subscriptions/'.$image_name;
        $get_sub_data->updated_at = date('Y-m-d H:i:s');
        $get_sub_data->save();
        return redirect()->route('admin.subscription')->with('message', 'Updated');
    }


    public function get_category_wise_products(Request $request){
        $post_data = $request->input();
        // print_r($post_data);
        $category_id = $post_data['id'];


      $category = Category::where('id', $category_id)->active()->first();

      if($category) {

        $products = $category->products
                  ->load('product', 'product.packs', 'product.packs.details', 'product.packs.inventory')
                  ->pluck('product');
        $products = $products->where('is_active',1)->sortByDesc('is_featured');
        $data['category'] = $category;
        $products = $products->map(function ($product) {
                          $product->append(['base_pack_price', 'base_pack']);
                          return $product;
                        });
        $data['products'] = $products;

      }


        $get_cat_pro = ProductCategory::with(['product'])->where('category_id',$category_id)->get();
        // $output = '';
        $output = '<option value="">Select</option>';
        if(!empty($products->toArray()))
        {
            // print_r($products->toArray());
            // exit;
            foreach ($products as $key => $value) {
                // print_r($value->toArray());
                if ($value['type'] == 'regular'){
                    if( $value['base_pack_price_without_discount'] != $value['base_pack_price'] )
                    {
                     $value['base_pack_price_without_discount'];
                    }
                 $mainprice =  $value['base_pack_price'];
                }

                if ($value['type'] == 'assorted')
                {
                if( $value['base_pack_price'] != ($value['base_pack_price'] - $value['base_pack']['discount']) )
                {
                 $value['base_pack_price_without_discount'];
                }
                $mainprice =  ($value['base_pack_price'] - $value->base_pack['discount']);
                }
                // echo $mainprice;
                // continue;
                if($value['type'] == 'regular')
                {
               // $output .= '<li class="li_data" style="margin-top:10px;margin-bottom:10px" data-id="'.$value['id'].'"><div class="row"><div class="col-md-8 col-sm-8 col-xs-8"><input type="checkbox" name="products[]" class="pro_checkbox" style="margin-right:9px" value="'.$value['id'].'"><span class="pro_name_span" data-id="'.$value['id'].'">'.$value['name'].'</span><span class="price_pro" style="font-weight:800">- ₹ '.$value['price'].'</span></div><div class="col-md-1 col-sm-1 col-xs-1"><a class="btn btn-success add_qty_btn">+</a></div><div class="col-md-1 col-sm-1 col-xs-1"><input type="number" class="qty_data" name="quantity[]" value="1" style="width:67px;border-width:0;border:none"> <input type="hidden" class="pro_price" name="pro_price[]" value="'.$value['price'].'"></div><div class="col-md-1 col-sm-1 col-xs-1"><a class="btn btn-danger remove_qty_btn">-</a></div></div></li>';
                $output .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
            }
            }
        }

        echo $output;

    }

    public function delete($id){
        // $reqdata = $request->input();
        // $id = isset($reqdata['id']) ? $reqdata['id'] : '';

        if (!Subscription::where('id', $id)->delete()) {
            return back()->with('error', 'Failed');
        }

        return back()->with('message', 'Deleted');
    }

    public function users_delete($id){

        if (!UserSubscription::where('id', $id)->delete()) {
            return back()->with('error', 'Failed');
        }

        return back()->with('message', 'Deleted');
    }

    public function users_index(){
        $subscription = UserSubscription::with(['subscription'])->get();
        return view('admin.subscription.users_index', compact('subscription'));
    }

    public function user_change_sub_status(Request $request){
        $req_data = $request->input();
        $id = isset($req_data['id']) ? $req_data['id'] : '';

        $user_sub = UserSubscription::where('id',$id)->first();
        if($user_sub->status == 1){
            $user_sub->status = 2;
            $send = 2;
            $sub_id_latest = $user_sub->razorpay_sub_id;
            if($sub_id_latest != ''){
                $api = new Api($this->keyId, $this->keySecret);
                $subdata = $api->subscription->fetch($sub_id_latest);
                if($subdata['status'] != 'expired'){
                $api->subscription->fetch($sub_id_latest)->pause(array('pause_at'=>'now'));
                }
            }
        }else{
            $user_sub->status = 1;
            $send = 1;
            $sub_id_latest = $user_sub->razorpay_sub_id;
            if($sub_id_latest != ''){
            $api = new Api($this->keyId, $this->keySecret);
            $subdata = $api->subscription->fetch($sub_id_latest);
            if($subdata['status'] != 'expired'){
                $api->subscription->fetch($sub_id_latest)->resume(array('resume_at'=>'now'));
            }
            }
        }
        $user_sub->save();
        echo $send;
    }

    public function get_products_packs(Request $request){
        $req_data = $request->input();
        $id = isset($req_data['id']) ? $req_data['id'] : '';
        // print_r($req_data);
        $output = '<option value="">Select</option>';

        $get_pro_packs = ProductPackMap::where('product_id',$id)->get();
        // print_r($get_pro_packs->toArray());
        if(!empty($get_pro_packs)){
            foreach ($get_pro_packs as $key => $value) {
                $output .= '<option value="'.$value->details->id.'">'.$value->details->title.'</option>';
            }
        }
        echo $output;
    }

    public function users_orders($id){
        // echo $id;
        $request = request()->input();
        // print_r($request);
        // exit;
        $status = '';
        $filterType = '';
        $start = '';
        $end = '';
        $get_user_sub_data = UserSubscription::with(['subscription'])->where('id',$id)->first();
        $get_sub_orders = Order::where('subscription_order',1)->where('user_subscription_id',$id)->where('status',1);


       $get_sub_orders->orderBy('created_at', 'desc');
        if(Auth::user()->branch_id!=""){
            $get_sub_orders = $get_sub_orders->where('branch_id', Auth::user()->branch_id);
        }
        if (isset($request['selectedBranch']) && $request['selectedBranch']!=null){
            $selectedBranch=$request['selectedBranch'];
            $get_sub_orders = $get_sub_orders->where('branch_id', $selectedBranch);

        }
        if (isset($request['status']) && $request['status'] != null){
            $status = $request['status'];
            $get_sub_orders = $get_sub_orders->where('status', $status);

        }
        if ( isset($request['start']) && isset($request['end']) && $request['start'] != null && $request['end'] != null){
            $start = $request['start'];
            $end = $request['end'];

            $get_sub_orders = $get_sub_orders
                        ->whereDate('created_at', '<=', $end)
                        ->whereDate('created_at', '>=', $start);

        }
        if(isset($request['datetime']) && $request['datetime'] != null){
            $filterType=$request['datetime'];
        }

        $get_sub_orders = $get_sub_orders->latest()->get()->append('products');


        // $get_sub_orders->get();
        return view('admin.subscription.user_orders',compact('get_user_sub_data','get_sub_orders','status','filterType','start','end'));
    }


}
