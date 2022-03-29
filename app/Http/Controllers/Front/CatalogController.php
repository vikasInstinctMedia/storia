<?php

namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Session;
use Illuminate\Support\Facades\Input;
use Validator;
use App\CustomClasses\ColectionPaginate;
use App\Traits\CartTrait;
use DB;
use App\Traits\CommonDataTrait;

class CatalogController extends Controller
{
    use CartTrait, CommonDataTrait;

    // CATEGORIES SECTON

    public function categories()
    {
        return view('front.categories');
    }

    /**
     * @author Aakash and piyush
     * loading page as per the slug, since there is same URL structure for both.
     * /{slug}
     *
     */

    public function category($slug)
    {
        $data['trending_products'] = $this->getTrendingProductList();

        $category = Category::where('slug', $slug)->active()->first();

        // dd($category->products->first()->base_pack->details->title);
        if ($category) {

            $products = $category->products
                ->load('product', 'product.packs', 'product.packs.details', 'product.packs.inventory')
                ->pluck('product');
            // dd($products->first());
            // $category->products->load('packs', 'packs.details');
            // Get all the products related to category
            $products = $products->where('is_active', 1)->where('user_diy_pack', 0)->sortByDesc('is_featured');
            // dd($products);
            // $products->append('base_pack');
            $data['category'] = $category;

            $products = $products->map(function ($product) {
                $product->append(['base_pack_price', 'base_pack']);
                return $product;
            });

            $data['prods']    = ColectionPaginate::paginate($products, 50);

            $data['products'] = $products;

            $data['meta_title'] = $category->meta_title;
            $data['meta_description'] = $category->meta_description;
            // dd($data);
            return view('front.products', $data);
        }

        $product = Product::with(['categories'])->where('slug', $slug)->active()->first();

        if ($product) {
            $product->append('base_pack_price');
            // Get specific product for details page
            $data['product'] = $product->load('seo', 'packs', 'images');
            // $this->loadAllInformationInJson();
            // dd($product->categories()->first()->category->id);
            $data['faqs']    = $this->getFAQs($product->categories());
            $data['meta_title'] = $product->meta_title;
            $data['meta_description'] = $product->meta_description;
            // dd($product);
            // echo '<pre>';
            // for recommended  part starts here--------------------------------
            $pro_data = $product->toArray();
            $cat = false;
            $cat_id = '';
            if ($pro_data['categories'] != '') {
                // echo 'here';
                foreach ($pro_data['categories'] as $key => $cat_data) {
                    // print_r($cat_data);
                    if ($cat_data['category_id'] == 1 || $cat_data['category_id'] == 2) {
                        $cat = true;
                        $cat_id = $cat_data['category_id'];
                    }
                }
            }

            if ($cat) {

                $category_new = Category::where('id', $cat_id)->active()->first();

                // dd($category->products->first()->base_pack->details->title);
                if ($category_new) {

                    $products_new = $category_new->products
                        ->load('product', 'product.packs', 'product.packs.details', 'product.packs.inventory')
                        ->pluck('product');

                    $products_new = $products_new->where('is_active', 1)->where('user_diy_pack', 0)->sortByDesc('is_featured');
                    $data['category_new'] = $category_new;
                    $products_new = $products_new->map(function ($product) {
                        $product->append(['base_pack_price', 'base_pack']);
                        return $product;
                    });

                    $data['prods_new']    = ColectionPaginate::paginate($products_new, 50);

                    $data['products_new'] = $products_new;
                    $data['category_id'] = $cat_id;


                    // dd($data);
                }
            }
            // for recommended product part ends here---------------------------

            // for frequently bought part starts here---------------------------
            $pro_data_2 = $product->toArray();
            $cat_2 = false;
            $cat_id_2 = '';
            if ($pro_data_2['categories'] != '') {
                // echo 'here';
                foreach ($pro_data_2['categories'] as $key => $cat_data) {
                    // print_r($cat_data);
                    if ($cat_data['category_id'] == 1 || $cat_data['category_id'] == 2 || $cat_data['category_id'] == 3 || $cat_data['category_id'] == 4) {
                        $cat_2 = true;
                        $cat_id_2 = $cat_data['category_id'];
                    }
                }
            }

            $data['category_id_2'] = $cat_id_2;

            if($cat_id_2 == 1)
            {
                $show_array_2 = [38,30];
            }elseif ($cat_id_2 == 2) {
                $show_array_2 = [37,30];
            }
            elseif ($cat_id_2 == 3) {
                $show_array_2 = [37,30];
            }
            elseif ($cat_id_2 == 4) {
                $show_array_2 = [37,38];
            }else{
                $show_array_2 = [];
            }

            $j=0;
            foreach ($show_array_2 as $key => $prnew) {
                $product = Product::with(['categories'])->where('id', $prnew)->active()->first();

                if ($product) {
                    $product->append('base_pack_price');
                    // Get specific product for details page
                    $data['product_freq'][$j] = $product->load('seo', 'packs', 'images');
                    // $this->loadAllInformationInJson();
                    // dd($product->categories()->first()->category->id);
                    $data['faqs_freq'][$j]    = $this->getFAQs($product->categories());
                }
                $j++;
            }

            // dd($data);
            // echo $cat_2;
            // echo '<br>';
            // echo $cat_id_2;
            // exit;
            // if ($cat_2) {

            //     $category_new_2 = Category::where('id', $cat_id_2)->active()->first();

            //     // dd($category->products->first()->base_pack->details->title);
            //     if ($category_new_2) {

            //         $products_new_2 = $category_new_2->products
            //             ->load('product', 'product.packs', 'product.packs.details', 'product.packs.inventory')
            //             ->pluck('product');

            //         $products_new_2 = $products_new_2->where('is_active', 1)->where('user_diy_pack', 0)->sortByDesc('is_featured');
            //         $data['category_new_2'] = $category_new_2;
            //         $products_new_2 = $products_new_2->map(function ($product) {
            //             $product->append(['base_pack_price', 'base_pack']);
            //             return $product;
            //         });

            //         $data['prods_new_2']    = ColectionPaginate::paginate($products_new_2, 50);

            //         $data['products_new_2'] = $products_new_2;
            //         $data['category_id_2'] = $cat_id_2;


            //         // dd($data);
            //     }
            // }
            // for frequently bought part ends here-----------------------------

            return view('front.product_details', $data);
        }

        abort(404);
    }

    private function loadAllInformationInJson()
    {
        $products = Product::all();


        foreach ($products as $product) {
            $arrayInformation = [];
            $elements = explode("\r\n", $product->nutritional_information);

            foreach ($elements as $value) {
                $keyValue = explode('-', $value);
                // if(empty($keyValue[1])) {
                //   dump($product);
                //   dd( $product->nutritional_information);
                // }
                $arrayInformation[$keyValue[0]] = $keyValue[1];
            }

            $product->nutritional_information_json = json_encode($arrayInformation);
            // dd($arrayInformation);
            $product->save();
        }
    }
}
