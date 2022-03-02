<?php

namespace App\Observers;

use App\Models\ProductPackMap;
use App\Models\Inventory;
use App\Models\Branch;

class ProductPackMapObserver
{
    /**
     * Handle the ProductPackMap "created" event.
     *
     * @param  \App\Models\ProductPackMap  $productPackMap
     * @return void
     */
    public function created(ProductPackMap $productPackMap)
    {
        $branches = Branch::all();

        $branches->each(function($branch) use($productPackMap) {
            Inventory::create([
                'branch_id' => $branch->id,
                'product_pack_map_id' => $productPackMap->id,
                'quantity' => 0
            ]);
        });
        
    }

    /**
     * Handle the ProductPackMap "updated" event.
     *
     * @param  \App\Models\ProductPackMap  $productPackMap
     * @return void
     */
    public function updated(ProductPackMap $productPackMap)
    {
        //
    }

    /**
     * Handle the ProductPackMap "deleted" event.
     *
     * @param  \App\Models\ProductPackMap  $productPackMap
     * @return void
     */
    public function deleted(ProductPackMap $productPackMap)
    {
        Inventory::where('product_pack_map_id',  $productPackMap->id )->delete();
    }

    /**
     * Handle the ProductPackMap "restored" event.
     *
     * @param  \App\Models\ProductPackMap  $productPackMap
     * @return void
     */
    public function restored(ProductPackMap $productPackMap)
    {
        //
    }

    /**
     * Handle the ProductPackMap "force deleted" event.
     *
     * @param  \App\Models\ProductPackMap  $productPackMap
     * @return void
     */
    public function forceDeleted(ProductPackMap $productPackMap)
    {
        //
    }
}
