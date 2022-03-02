<?php

namespace App\Traits;

use App\Models\Category;
use App\Models\Product;
use DB;

trait CommonDataTrait {

    private function getCategoriesList()
    {
    //   return cache()->remember('categories_list', 60 * 60 * 2, function() {
        return Category::active()->get();
    //   });
    }

    /**
     * @todo replace logic with trending product logic
     */
    private function getTrendingProductList()
    {
    //   $trending = cache()->remember('trending_products', 60 * 60, function() {
        return Product::active()->with('packs')
                    ->inRandomOrder()
                    ->limit(5)->get()
                    ->append(['base_pack_price', 'base_pack_price_without_discount']);
    //   });
    //   return $trending;
    }


    private function getFAQs($categories)
    {

      $categories = $categories->get();

      $categoryId = $categories->first()->category->id;

      // Static code for NAS category @todo

      // dd($categories->whereIn('category_id', [6,1])->count());

      if($categories->whereIn('category_id', [6,1])->count() == 2 ) {
        $categoryId = 6;
      } else {
        // dd($categories);
        $categoryId = $categories->where('category_id', '!=', 6 )->first()->category->id;
      }
      $faqs = DB::table('frequently_asked_questions')->where('category_id', $categoryId)->get()->toArray();

      return $faqs;
    }

}
