<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderProduct;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        try {
            if (empty($order->products)) {
                return false;
            }

            $productData = [];
            foreach ($order->products as $product) {
                $productData[] = [
                    'order_id'            => $order->id,
                    'product_pack_map_id' => $product['pack_id'],
                    'quantity'            => $product['quantity']
                ];
            }

            OrderProduct::insert($productData);
        } catch (\Exception $e) {
            info('Order -> observer ==> ' . $e->getMessage());
        }
    }

    /**
     * If the order status is changed and it has been CANCELLED, then re add the qty in stock 
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        try {
            if ($order->isDirty('status') && $order->status == Order::CANCELLED) {
                // refill the stock
                $branch = $order->branch;
                // dd($order->products);
                foreach ($order->products as $product) {
                    $inventory = $branch->inventories()->where('product_pack_map_id', $product['pack_id'])->first();
                    if (!$inventory) {
                        continue;
                    }
                    $inventory->quantity = $inventory->quantity + $product['quantity'];
                    $inventory->save();
                }
            }
        } catch (\Exception $e) {
            info('Order -> observer ==> ' . $e->getMessage());
        }
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
