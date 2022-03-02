<?php

namespace App\Http\Controllers\User;

use App\CustomClasses\ColectionPaginate;
use App\Helpers\OrderStatusConstants;
use App\Helpers\ShippingAPIHelper;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Pack;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\UserSubscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*---------------- Index ---------------- */

    public function index()
    {
        $user = Auth::user();

        // Maybe for recent orders tab
        $orderss = Order::query()
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->get();


        // Maybe for dashboard orders tab

        $dashboardOrders = $user->orders()
            ->latest()
            ->get();

        $dashboardOrders = $this->fetchTrackingData($dashboardOrders);

        $user_subscriptions = UserSubscription::with(['subscription'])->where('users_id',$user->id)->get();


        return view('user.dashboard', compact('user','dashboardOrders','orderss','user_subscriptions'));
    }


    /*---------------- Fetch Tracking Data ---------------- */

    private function fetchTrackingData($orders): Collection
    {

        try {

            $filteredOrders = $orders->whereNotIn('status', [
                Order::COMPLETED,
                Order::DECLINED
            ]);

            $helper = new ShippingAPIHelper();

            foreach ($filteredOrders as $key => $order) {

                $trackingDataCollection = $helper->trackOrder($order->awb_number);

//                dd($trackingDataCollection[count($trackingDataCollection) - 1]);

                $orders[$key]->tracking_status = $trackingDataCollection->last()->message;
            }


            return $orders;

        } catch (Exception $e) {
            info("Tracking API User PAGE === " . $e->getMessage());
            return $orders;
        }

    }

    public function create_pack(){
        $categories = Category::active()->get();
        $packs = Pack::all();
        $products = Product::where('type','regular')->get();
        return view('user.create-pack', compact('categories','packs','products'));
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


        // echo '<pre>';
        // print_r($products->toArray());

// foreach ($products as $key => $prod) {
//     if ($prod->type == 'regular'){
//         if( $prod->base_pack_price_without_discount != $prod->base_pack_price )
//         {
//         echo $prod->base_pack_price_without_discount;
//         }
//      echo $prod->base_pack_price;
//     }

//     if ($prod->type == 'assorted')
//     {
//     if( $prod->base_pack_price != ($prod->base_pack_price - $prod->base_pack->discount) )
//     {
//     echo $prod->base_pack_price_without_discount;
//     }
//     echo ($prod->base_pack_price - $prod->base_pack->discount);
//     }
// }
        // echo '</pre>';
        // exit;
      }


        $get_cat_pro = ProductCategory::with(['product'])->where('category_id',$category_id)->get();
        $output = '';

        if(!empty($products->toArray()))
        {
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
                $output .= '<li class="li_data" style="margin-top:10px;margin-bottom:10px" data-id="'.$value['id'].'"><div class="row"><div class="col-md-8 col-sm-8 col-xs-8"><input type="checkbox" name="products[]" class="pro_checkbox" style="margin-right:9px" value="'.$value['id'].'"><span class="pro_name_span" data-id="'.$value['id'].'">'.$value['name'].'</span><span class="price_pro" style="font-weight:800">- ₹ '.$value['price'].'</span></div><div class="col-md-1 col-sm-1 col-xs-1"><a class="btn btn-success add_qty_btn">+</a></div><div class="col-md-1 col-sm-1 col-xs-1"><input type="number" class="qty_data" name="quantity[]" value="1" style="width:67px;border-width:0;border:none"> <input type="hidden" class="pro_price" name="pro_price[]" value="'.$value['price'].'"></div><div class="col-md-1 col-sm-1 col-xs-1"><a class="btn btn-danger remove_qty_btn">-</a></div></div></li>';
                }
            }
        }

        echo $output;

    }

    public function save_pack(Request $request){
        // print_r($_POST);
        $postdata = $request->input();

        $product_main = isset($postdata['product_main']) ? $postdata['product_main'] : '';
        $qty_main = isset($postdata['qty_main']) ? $postdata['qty_main'] : '';
        $category_id = isset($postdata['category_id']) ? $postdata['category_id'] : '';

        $calculate_total = 0;
        $product_name = '';
        $product_desc = '';

        $user_id = Auth::id();
        $timestamp = time();

        $sku = 'SKU_'.$timestamp.'_'.$user_id;

        if($product_main == ''){
            return;
        }

        // echo '<pre>';
        $products_data = [];
        $i = 0;
        foreach ($product_main as $key => $prd) {
            // echo $prd;
            for ($j=1; $j <= $qty_main[$i]; $j++) {
                array_push($products_data,$prd);
            }
            $product = Product::where('id', $prd)->active()->first();

            if($product) {
              $product->append('base_pack_price');
              // Get specific product for details page
              $data['product'] = $product->load('seo', 'packs', 'images');
              // $this->loadAllInformationInJson();
              // dd($product->categories()->first()->category->id);
              $product = $product->toArray();
            //  print_r($product);

              // dd($product->includedProducts);

            }

            $product_name = $product_name.$product['name'].'-'.$qty_main[$i].',';
            $product_desc = $product_desc.$product['name'].',';
        // if ($product['type'] == 'regular'){
        //     if( $product['base_pack_price_without_discount'] != $product['base_pack_price'] )
        //     {
        //      $product['base_pack_price_without_discount'];
        //     }
        //  $mainprice =  $product['base_pack_price'];
        // }
        $calculate_total = $calculate_total+($product['price']*$qty_main[$i]);
        $i++;
    }
    // print_r($products_data);
        // echo $calculate_total;
        // exit;

        $productData = array(
            'name' => $product_name.$timestamp,
            'description' => $product_desc,
            'price' => $calculate_total,
            'slug' => $sku,
            'banner_image' => '--',
            'type' => 'assorted',
            'user_diy_pack' => 1,
            'banner_image'=>'product/user-default-pack.png',
        );
        $product = Product::create($productData);

        // exit;
        // Create Product Categories
        // foreach($request->category_ids as $category_id) {
            $product->categories()->create( [
                'category_id' => $category_id
            ]);
        // }

        // Create Product Pack maps
        // foreach($request->packs as $pack_id) {
            $pack = $product->packs()->create([
                'pack_id' => 2,
                'sku'     => $sku,
                'discount'=> 0
            ]);
        // }

        $branch_data = Branch::get();
        $del_inv = Inventory::where('product_pack_map_id',$pack->id);
        $del_inv->delete();
        foreach ($branch_data as $brch) {
            $inventories = new Inventory();
            $inventories->branch_id = $brch->id;
            $inventories->product_pack_map_id = $pack->id;
            $inventories->quantity = 10;
            $inventories->save();
        }
        // If the product is type of assorted product then add included product
        // if($request->type == "assorted") {
            collect($products_data)->each(function($includedProduct) use($product) {
                $print = $product->includedProducts()->create([
                    'included_product_id' => (int)$includedProduct
                ]);
            });
        // }

        $pro_id = $product->id;
        $product = Product::where('id', $pro_id)->active()->first();

        if($product) {
          $product->append('base_pack_price');
          // Get specific product for details page
          $data['product'] = $product->load('seo', 'packs', 'images');
          // $this->loadAllInformationInJson();
          // dd($product->categories()->first()->category->id);
        //   $data['faqs']    = $this->getFAQs($product->categories());

          // dd($product);
          // dd($product->includedProducts);

          return view('user.add-pack-to-cart', $data);
        }
    }
}
