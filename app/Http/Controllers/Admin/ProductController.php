<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Admin\ProductRequest;
use DB;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Pack;

use App\Models\ProductPackMap;
use App\Traits\ProductHelperTrait;
use Storage;
use File;

class ProductController extends Controller
{
    use ProductHelperTrait;

    public function index()
    {
        $categories = Category::active()->get();
        return view('admin.product.index',compact('categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $packs = Pack::all();
        $products = Product::where('type','regular')->get();
        return view('admin.product.add', compact('categories','packs', 'products'));
    }

    public function store(ProductRequest $request)
    {
        // dd($request->all());
        $data = $request->all();

        $productData = $request->only('name', 'type', 'slug', 'price', 'description', 'nutritional_information', 'is_featured', 'know_your_fruit_title', 'know_your_fruit_desc');

        if($request->has('banner_image') ) {
            $productData['banner_image'] =  $request->file('banner_image')->store('product');
        }

        // Parse Usp data to JSON if updated

        if( count($request->usp) > 1 )  {
            $uspArray = $this->uploadUsp($request->usp, $request->usp_icon);
            $productData['usp'] = json_encode($uspArray);
        }

        // Parse fruiticons data to JSON if updated
        if(count($request->fruiticon) > 1 )  {
            $iconsArray = $this->uploadFruitIconDetails($request->fruiticon, $request->fruiticon_icon );
            $productData['fruiticons'] = json_encode($iconsArray);
        }

        if(count($request->ingredient) > 1){
            $ingArray = $this->uploadIngredientDetails($request->ingredient, $request->ingredient_icon );
            $productData['ingredients'] = json_encode($ingArray);
        }

        DB::beginTransaction();


        $nutritional_information_json = [];
        $skuList = explode(PHP_EOL, $productData['nutritional_information']);

        foreach ($skuList as $key => $value) {
            $innerdata = explode('-', $value);
            $nutritional_information_json[$innerdata[0]] = $innerdata[1];
        }

        $productData['nutritional_information_json'] = json_encode($nutritional_information_json);
        try {

            // dd($productData);
            $product = Product::create($productData);

            // Insert Images
            foreach($request->thumbnail_image as $image) {
                $image = $image->store('product');
                $product->images()->create([
                    'image' => $image
                ]);
            }


            // Create Product Categories
            foreach($request->category_ids as $category_id) {
                $product->categories()->create( [
                    'category_id' => $category_id
                ]);
            }

            // Create Product Pack maps
            foreach($request->packs as $pack_id) {
                $pack = $product->packs()->create([
                    'pack_id' => $pack_id,
                    'sku'     => $request->sku[$pack_id],
                    'discount'=> $request->discount[$pack_id]
                ]);
            }

            // If the product is type of assorted product then add included product
            if($request->type == "assorted") {
                collect($request->included_products)->each(function($includedProduct) use($product) {
                    $print = $product->includedProducts()->create([
                        'included_product_id' => (int)$includedProduct
                    ]);
                });
            }

            // create SEO details
            $product->seo()->create(array_merge($request->only('meta_title', 'meta_description'), [
                'meta_image' => isset($data['meta_image']) ? $request->file('meta_image')->store('product') : ''
            ]));

            // dd('done');
            DB::commit();

        } catch(\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }

        // dd($product);
        return redirect()->route('admin.products.index')->with('message', 'created successfully');
    }

    public function getList(Request $request)
    {

        $reqdata = $request->input();
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $url = $actual_link;
$components = parse_url($url);
parse_str($components['query'], $results);
// print_r($results);
        // exit;
        $category_id = isset($results['category']) ? $results['category'] : '';
        $products = Product::where('user_diy_pack',0)->active();
// exit;
        if($category_id != ''){
            // $products->with(['categories' => function($q) use ($category_id){
            //     $q->where('category_id', $category_id);
            // }]);
            $products->with('category');
        }else{
            $products->with('category');
        }


        return datatables()->of($products)
                    ->addIndexColumn()
                    ->editColumn('thumbnail_image', function($row) {
                        return $row->thumbnail_image ? asset("storage/".$row->thumbnail_image) : "";
                    })
                    ->addColumn('action', function($row){
                           return [
                                'view_url' => route('admin.products.show',[ 'product' => $row->id]),
                                'edit_url' => route('admin.products.edit', ['product' => $row->id])
                           ];
                    })
                    ->toJson();

    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $packs = Pack::all();
        $products = Product::where('type','regular')->get();
        $includedProductsIdsArray = [];
        if($product->type == 'assorted') {
            $includedProductsIdsArray = $product->includedProducts()->pluck('included_product_id')->toArray();
            // dd($includedProductsIdsArray);
        }

        return view('admin.product.edit', compact('product', 'categories', 'packs', 'products', 'includedProductsIdsArray'));
    }

    public function update(ProductRequest $request)
    {
        // dump($request->all());
        // upload banner image
        $productData = $request->only('name', 'slug','type','season','price', 'description', 'nutritional_information', 'is_featured', 'know_your_fruit_title', 'know_your_fruit_desc');

        if($request->has('banner_image') ) {
            $productData['banner_image'] =  $request->file('banner_image')->store('product');
        }

        $originalProductData = Product::where('id', $request->product_id)->firstOrFail();

        // Parse Usp data to JSON if updated
        if( $request->usp )  {
            $uspArray = $this->updatedUspDetails($request->usp, $request->usp_icon, $originalProductData->usp);
            $productData['usp'] = json_encode($uspArray);
        }

        // Parse ingrediants data to JSON if updated
        if($request->ingredient)  {
        // if($request->ingredient && $request->type != "assorted")  {
            $uspArray = $this->updatedIngrediantDetails($request->ingredient, $request->ingredient_icon, $originalProductData->ingredients );
            $productData['ingredients'] = json_encode($uspArray);
        }

        // Parse fruiticons data to JSON if updated
        if($request->fruiticon)  {
        // if($request->fruiticon && $request->type != "assorted")  {
            $uspArray = $this->updatedFruitIconDetails($request->fruiticon, $request->fruiticon_icon, $originalProductData->fruiticons);
            $productData['fruiticons'] = json_encode($uspArray);
        }

        $nutritional_information_json = [];
        $skuList = explode(PHP_EOL, $productData['nutritional_information']);

        foreach ($skuList as $key => $value) {
            $innerdata = explode('-', $value);
            $nutritional_information_json[$innerdata[0]] = $innerdata[1];
        }

        $productData['nutritional_information_json'] = json_encode($nutritional_information_json);


        // dd('fruiticons')
        // dd($productData);


        DB::beginTransaction();

        try {

            $product =  Product::where('id', $request->product_id)->update($productData);
            $product = Product::where('id', $request->product_id)->firstOrFail();

            // Update Categories
            $categories = $product->categories()->pluck('category_id')->toArray();
            $removed = array_diff($categories, $request->category_ids);
            $added = array_diff( $request->category_ids, $categories);

            $product->categories()->whereIn('category_id',$removed)->delete();

            foreach($added as $category_id) {
                $product->categories()->create( [
                    'category_id' => $category_id
                ]);
            }

            // Update Images
            if($request->thumbnail_image && count($request->thumbnail_image)) {
                $this->uploadAndSaveProductImages($product ,$request->thumbnail_image);
            }

            // Update Packs
            $packs = $product->packs()->pluck('pack_id')->toArray();
            $removed = array_diff($packs, $request->packs);
            $added = array_diff( $request->packs, $packs);


            // dump($request->discount);
            // dump($removed);
            // dump($added);
            // dump($request->packs);
            // dd($packs);
            dump($product->packs()->whereIn('pack_id',$removed)->delete());
            // delete from inventory as well
            // dump(Inventory::whereIn('product_pack_map_id', $productPackMapIds)->delete());

            foreach($request->packs as $pack_id) {
                $pack = ProductPackMap::updateOrCreate([
                    'pack_id'    => $pack_id,
                    'product_id' => $product->id
                ],[
                    'sku'     => $request->sku[$pack_id],
                    'discount'=> $request->discount[$pack_id]
                ]);
                //  dd($pack);
            }

            // If the product is type of assorted product then add included product
            if($request->type == "assorted") {
                $product->includedProducts()->delete();
                collect($request->included_products)->each(function($includedProduct) use($product) {
                    $print = $product->includedProducts()->create([
                        'included_product_id' => (int)$includedProduct
                    ]);
                });
            }


             DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }

        // dd('test');
        return redirect()->route('admin.products.index')->with('message', 'updated successfully');
    }

    private function uploadAndSaveProductImages($product, $images) : void
    {
        // delete Old images
        $product->images->each(function($image) {
            if(Storage::exists('storage/'. $image->image)) {
                unlink('storage/'. $image->image);
            }
        });

        $product->images()->delete();

        // Add all new
        foreach($images as $image) {
            $image = $image->store('product');
            $product->images()->create([
                'image' => $image
            ]);
        }
    }

    private function updatedUspDetails(array $usps , $uspIcons, $oldJson)
    {
        $oldData = (array) json_decode($oldJson);
        $oldDataNew = json_decode($oldJson,true);
        if($oldDataNew == NULL){
            $oldDataNew = array();
        }
        // In case the database keys does not match reset the keys
        $oldData = array_values($oldData);
        array_unshift($oldData,"");
        unset($oldData[0]);

        $oldDataNew = array_values($oldDataNew);
        array_unshift($oldDataNew,"");
        unset($oldDataNew[0]);

        $uspData = [];

        if( ! $uspIcons ) {
            $uspData = $oldDataNew;
        }
        // print_r($usps);
        // exit;
        foreach($usps as $key => $usp) {

            if($usp && $uspIcons && isset($uspIcons[$key])) {
                // upload image
                $fileName = $uspIcons[$key]->getClientOriginalName();
                if( ! Storage::exists('storage/usp/'. $fileName)) {
                    $iconPath = $uspIcons[$key]->storeAs('usp', $fileName );
                } else {
                    $iconPath = Storage::get('storage/usp/'. $fileName);
                }
                // dd($iconPath);

                $uspData[$key] = [
                    'usp'      => $usp,
                    'usp_icon' => $iconPath
                ];
            } else {
                // update the old array
                if(isset($uspData[$key])){
                $uspData[$key]['usp'] = $usp;
                $uspData[$key]['usp_icon'] = $oldDataNew[$key]['usp_icon'];
                }
            }
        }


        // dd($uspData);
        return $uspData;
    }


    private function updatedIngrediantDetails(array $ingredients ,  $ingredientIcons, $oldJson)
    {
        $oldData = (array) json_decode($oldJson);
        $oldDataNew = json_decode($oldJson,true);
        if($oldDataNew == NULL){
            $oldDataNew = array();
        }
        // In case the database keys does not match reset the keys
        $oldData = array_values($oldData);
        array_unshift($oldData,"");
        unset($oldData[0]);

        $oldDataNew = array_values($oldDataNew);
        array_unshift($oldDataNew,"");
        unset($oldDataNew[0]);

        $ingredientData = [];

        if( ! $ingredientIcons ) {
            $ingredientData = $oldDataNew;
        }
        foreach($ingredients as $key => $ingredient) {
            if($ingredient && $ingredientIcons && isset($ingredientIcons[$key])) {
                // upload image
                $fileName = $ingredientIcons[$key]->getClientOriginalName();
                if( ! Storage::exists('storage/ingredient/'. $fileName)) {
                    $iconPath = $ingredientIcons[$key]->storeAs('ingredient', $fileName );
                } else {
                    $iconPath = Storage::get('storage/ingredient/'. $fileName);
                }

                $ingredientData[$key] = [
                    'ingredient'      => $ingredient,
                    'ingredient_icon' => $iconPath
                ];
            } else {
                // update the old array
                if(isset($ingredientData[$key])){
                $ingredientData[$key]['ingredient'] = $ingredient;
                $ingredientData[$key]['ingredient_icon'] = $oldDataNew[$key]['ingredient_icon'];
                }
            }
        }

        return $ingredientData;
    }


    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    private function updatedFruitIconDetails(array $fruiticons , $fruiticons_icons,  $oldJson)
    {
        $oldData = (array) json_decode($oldJson);
        $oldDataNew = json_decode($oldJson,true);

        if($oldDataNew == NULL){
            $oldDataNew = array();
        }
        // In case the database keys does not match reset the keys
        $oldData = array_values($oldData);
        array_unshift($oldData,"");
        unset($oldData[0]);

        $oldDataNew = array_values($oldDataNew);
        array_unshift($oldDataNew,"");
        unset($oldDataNew[0]);

        $fruitIconData = [];

        if( ! $fruiticons_icons ) {
            $fruitIconData = $oldDataNew;
        }

        foreach($fruiticons as $key => $fruiticon) {
            if($fruiticon && $fruiticons_icons  && isset($fruiticons_icons[$key])) {
                // upload image
                $fileName = $fruiticons_icons[$key]->getClientOriginalName();
                if( ! Storage::exists('storage/fruiticon/'. $fileName)) {
                    $iconPath = $fruiticons_icons[$key]->storeAs('fruiticon', $fileName );
                } else {
                    $iconPath = Storage::get('storage/fruiticon/'. $fileName);
                }
                // dd($iconPath);

                $fruitIconData[$key] = [
                    'fruiticon'      => $fruiticon,
                    'fruiticon_icon' => $iconPath
                ];
            } else {
                // update the old array
                if(isset($fruitIconData[$key])){
                $fruitIconData[$key]['fruiticon'] = $fruiticon;
                $fruitIconData[$key]['fruiticon_icon'] = $oldDataNew[$key]['fruiticon_icon'];
                }
            }
        }

        return $fruitIconData;
    }

    public function destroy()
    {

    }

}
