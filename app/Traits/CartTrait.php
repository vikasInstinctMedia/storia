<?php

namespace App\Traits;
use Session;
use Auth;

trait CartTrait {

    // Session key "cart"

    private function addToCart(array $data)
    {
        $oldCart = $this->getCartData();

        $items = [];
        if($oldCart && count($oldCart['items'])) {
            // Check if product exists
            $exist = collect($oldCart['items'])->filter(function($value) use ($data) {
                return $value['id'] == $data['id'] &&  $value['pack_id'] == $data['pack_id'];
            });

            if($exist->isNotEmpty()) {
                $oldCart['items'] = collect($oldCart['items'])->map(function ($value) use ($data)  {
                    if($value['id'] == $data['id']) {
                        $value['quantity'] += 1;
                    }
                    return $value;
                })->toArray();
            } else {
                $oldCart['items'][] = $data;
            }

            $items = $oldCart['items'];
        } else {
            $items[] = $data;
        }

        // $cart['items'] = $items;
        // $cart['total'] = collect($cart['items'])->sum('price');

        $cart = self::calculateValues($items);

        Session::put('cart', $cart);

        if(Auth::user()) {
            Auth::user()->cart()->updateOrCreate(['user_id' => Auth::user()->id ],['cart_data' => json_encode($cart)]);
        }

        return $cart;
    }

    private function removeFromCart(int $uniqueId)
    {
        $cart = $this->getCartData();

        $cart['items'] = collect($cart['items'])->reject(function($value) use($uniqueId) {
            return $value['unique_id'] == $uniqueId;
        })->toArray();

        $cart = self::calculateValues($cart['items']);

        Session::put('cart', $cart);

        if(Auth::user()) {
            Auth::user()->cart()->updateOrCreate(['user_id' => Auth::user()->id ],['cart_data' =>json_encode($cart)]);
        }

        return $cart;
    }

    private function getCartData()
    {
        return Session::get('cart');
    }


    private function updateCartProduct($uniqueId, $qty)
    {
        $oldCart = $this->getCartData();

        $items = [];
        // Check if product exists
        $items = collect($oldCart['items'])->map(function($value) use ($uniqueId, $qty) {
            if($value['unique_id'] == $uniqueId ) {
                $value['quantity'] = $qty;
            }
            return $value;
        });

        // dd($items);

        $cart = self::calculateValues($items);

        Session::put('cart', $cart);

        if(Auth::user()) {
            Auth::user()->cart()->updateOrCreate(['user_id' => Auth::user()->id ],['cart_data' => json_encode($cart)]);
        }

        return $cart;
    }

    private static function calculateValues($items)
    {
        $items = collect($items)->map(function($product) {
            $product['product_total'] = $product['quantity'] * $product['price'];
            return $product;
        });

        $subTotal = $items->sum('product_total');

        // @todo shipping charge should come from database table
        $shippingCharge = 50;
        if($subTotal < 400){
            $shippingCharge = 50;
        }else{
            $shippingCharge = 0;
        }

        return [
            'items'           => $items->toArray(),
            'sub_total'       => $subTotal,
            'shipping_charge' => $shippingCharge,
            'cod_charge'     => 0,
            'total'           => $subTotal + $shippingCharge
        ];
    }


    // Apply coupon and discount section

    private function percentageDiscountOnCart($coupon)
    {
        $cart = $this->getCartData();

        $cart['coupon'] = [
            'id' => $coupon->id,
            'code' => $coupon->code
        ];

        $cart['discount'] = ($cart['total']/100) * $coupon->value;

        $cart['total'] = $cart['total'] - $cart['discount'];

        Session::put('cart', $cart);

        // dd($cart);
    }

    private function fixedDiscountOnCart($coupon)
    {
        $cart = $this->getCartData();

        $cart['coupon'] = [
            'id' => $coupon->id,
            'code' => $coupon->code
        ];

        $cart['discount'] = $coupon->value;

        $cart['total'] = $cart['total'] - $coupon->value;

        Session::put('cart', $cart);
    }
}
