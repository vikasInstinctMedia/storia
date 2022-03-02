<?php

namespace App\Traits;

use App\Models\Address;
use App\Models\Inventory;
use DB;
use App\Models\Order;
use App\Models\ProductPackMap;

trait CheckoutUtility
{

    private function validateOrder($userData, $cart)
    {
        $errors = [];
        // check if pincode is deliverable

        $pincodes = DB::table('branch_deliverable_pincodes')->get()->pluck('pincode')->toArray();
        if (!in_array($userData['zip'], $pincodes)) {
            $errors[] = 'we do not deliver to this pincode ' . $userData['zip'];
        }

        // validate if inventory has products

        $items = collect($cart['items']);
        $inventoryPackIds = $items->pluck('pack_id');
        $branch = DB::table('branches')
            ->select('branches.*')
            ->join('branch_deliverable_pincodes', 'branch_deliverable_pincodes.branch_id', 'branches.id')
            ->where('branch_deliverable_pincodes.pincode', $userData['zip'])->first();


        $productsToCheck = DB::table('inventories')
            ->where('branch_id', $branch->id)
            ->whereIn('product_pack_map_id', $inventoryPackIds)
            ->get();

            // print_r($productsToCheck);
            // exit;

        foreach ($productsToCheck as $key => $inventory) {


            $item = $items->where('pack_id', $inventory->product_pack_map_id  )->first();

            // dd($item);

            if($item['quantity'] > $inventory->quantity ) {
                $name = $item['name'];

                $errors[] = "Opps ! Product " . $name . " is out of stock at your nearby branch";
            }


        }
        // dd($errors);
        // dd('errors');
        return $errors;
    }


    private function updateInventoryAfterOrder(Order $order)
    {
        // dump($order);

        $cart = unserialize($order->cart);

        foreach ($cart['items'] as $item) {
            $inventory = Inventory::where([
                'branch_id' => $order->branch_id,
                'product_pack_map_id' => (int)$item['pack_id']
            ])
                ->where('quantity', '>=', (int)$item['quantity'])
                ->first();
            // dd($inventory);
            if (!$inventory) {
                info('unable to subtract the quantity');
                return false;
            }
            $inventory->quantity = $inventory->quantity - $item['quantity'];
            $inventory->save();
        }

        return true;
    }

    private function add_address_to_database($address)
    {
        $new_address = new Address();
        $new_address->name = $address['name'];
        $new_address->email = $address['email'];
        $new_address->phone = $address['phone'];
        $new_address->address = $address['address'];
        $new_address->country = $address['country'];
        $new_address->city = $address['city'];
        $new_address->state = $address['state'];
        $new_address->zip = $address['zip'];
        $new_address->user_id = $address['user_id'];
        $new_address->save();
        return $new_address->id;
    }

    private function getConsignmentPackageDetails($cart)
    {
        // dump($cart);
        try {
            $data = [
                'height' => 0,
                'breadth' => 0,
                'length' => 0,
                'weight' => 0
            ];

            foreach ($cart['items'] as $key => $item) {

                // dump($item);
                $productPack =  DB::table('product_pack_maps')->where('id', $item['pack_id'])->first();

                $data['height'] = $data['height'] + ((int)$productPack->height * (int)$item['quantity']);

                $data['weight'] = $data['weight'] + ((int)$productPack->weight * (int)$item['quantity']);

                $data['breadth'] = ( $productPack->breadth > $data['breadth']  || $data['breadth'] == 0 ) ?
                                   $productPack->breadth :
                                   $data['breadth'];


                $data['length'] = ( $productPack->length > $data['length']  || $data['length'] == 0 ) ?
                                    $productPack->length :
                                    $data['length'];
                // dump($productPack);
            }

            // dump('data');
            // dd($data);
        } catch (\Exception $e) {
            info('Checkout Shipping == error while creating shipment' . json_encode($cart));
        }

        return $data;
    }
}
