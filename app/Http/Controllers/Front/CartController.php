<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CouponRequest;
use App\Models\Coupon;
// use App\Models\Cart;
use App\Models\Product;
use Session;
use Cart;
use App\Traits\CartTrait;

class CartController extends Controller
{
    use CartTrait;

    public function cart()
    {

        if (!Session::has('cart')) {
            return view('front.cart');
        }
        if (Session::has('already')) {
            Session::forget('already');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $products = $cart->items;
        $totalPrice = $cart->totalPrice;
        $mainTotal = $totalPrice;


        return view('front.cart', compact('products','totalPrice','mainTotal'));
    }

    public function cartview()
    {
        return view('load.cart');
    }

    public function addcart($productId, $packId)
    {
        $product = Product::where('id','=',$productId)->with('packs')->firstOrfail();

        $pack = $product->packs->where('id', $packId)->first();

        $packPrice = $pack->details->quantity * $product->price;
        if($product->type == "assorted") {
            $packPrice = $product->price;
        }

        if($pack->discount) {
            $packPrice =  $packPrice - $pack->discount;
        }


        $cart = $this->addToCart([
            'unique_id' => $product->id . $packId . rand(10, 100),
            'id'    => $product->id,
            'name'  => $product->name .' '. $pack->details->title ,
            'pack_name' => $pack->details->title,
            'price' => $packPrice,
            'slug'  => $product->slug,
            'thumbnail_image' => $product->banner_image,
            'pack_id' => $packId,
            'quantity' => 1,
        ]);

        return $this->successJsonResponse([
            'cart' => $cart ,
            'items_count' => count($cart['items']),
            'product' => $product

        ]);
    }

    public function removecart($id)
    {
        $cart = $this->removeFromCart($id);

        return $this->successJsonResponse(['cart' => $cart , 'items_count' => count($cart['items']) ]);
    }

    public function changeQuantity(Request $request, $unique_id)
    {
        $qty =  $request->qty;
        $cart = $this->updateCartProduct($unique_id,(int)$qty);
        return $this->successJsonResponse(['cart' => $cart ]);
    }


    public function cartpage()
    {
        return view('front.cartpage');
    }


    public function redeemCoupon(Request $request)
    {
        // dd($request->code);

        // check if already one coupon applied
        if( !empty( $this->getCartData()['coupon']) ) {
            return back()->with('error', 'You can apply only one coupon');
        }

        $coupon = Coupon::where('code', $request->code)->first();
        // dd($coupon);
        if( ! $coupon) {
            return back()->with('error', 'invalid coupon code');
        }

        if($coupon->valid_from && $coupon->valid_till) {
            if( ! now()->between($coupon->valid_from,$coupon->valid_till)) {
                return back()->with('error', 'Invalid coupon code');
            }
        }

        switch ($coupon->type) {
            case 'percentage':
                $this->percentageDiscountOnCart($coupon);
                break;

            case 'fixed':
                $this->fixedDiscountOnCart($coupon);
            break;

            default:
                info('coupon code failed');
                break;
        }

        // dd('valid');
        return back()->with('message', 'Coupon Applied');
    }

}
