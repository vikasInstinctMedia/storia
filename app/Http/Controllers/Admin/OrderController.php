<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ShippingAPIHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Order;
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
use Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // echo 1;
        // exit;
        $selectedBranch='';
        $status='';
        $start='';
        $end='';
        $filterType='';
        $orders = Order::with('user','branch')->where('subscription_order',0)
                ->orderBy('created_at', 'desc');
                if(Auth::user()->branch_id!=""){
                    $orders = $orders->where('branch_id', Auth::user()->branch_id);
                }
                if ($request->selectedBranch!=null){
                    $selectedBranch=$request->selectedBranch;
                    $orders = $orders->where('branch_id', $selectedBranch);

                }
                if ($request->status != null){
                    $status = $request->status;
                    $orders = $orders->where('status', $status);

                }
                if ($request->start != null && $request->end != null){
                    $start = $request->start;
                    $end = $request->end;

                    $orders = $orders
                                ->whereDate('created_at', '<=', $end)
                                ->whereDate('created_at', '>=', $start);

                }
                if($request->datetime != null){
                    $filterType=$request->datetime;
                }

                $orders = $orders->latest()->get()->append('products');

                $branches = Branch::all();
        return view('admin.order.index', compact('branches','orders','selectedBranch','status','filterType','start','end'));
    }

    public function getList(Request $request)
    {
        $orders = Order::with('user','branch')->where('subscription_order',0)
                    ->when( $request->selected_branch ,  function($query , $selectedBranch ) {
                        return $query->where('branch_id', $selectedBranch);
                    })
                    ->latest()->get()->append('products');

        $branches = Branch::all();

        // dd($request->selected_branch);

        return datatables()->of($orders)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           return [
                                'view_url' => route('admin.cfa.orders.show',[ 'order' => $row->id])
                           ];
                    })
                    ->with([
                        'branches' => $branches,
                    ])
                    ->toJson();
    }

    public function getlistByFilter(Request $request){

    }

    public function update(Request $request)
    {

    }

    public function show(Order $order)
    {
        // dd($order->with(['billing_address']));
        // $withaddress = $order->billing_address;
        // echo '<pre>';
        // print_r($order->toArray());
        // exit;
        return view('admin.order.show', compact('order') );
    }

    public function destroy()
    {

    }

    public function updateStatus(Request $request)
    {
        $order = Order::where('id', $request->order_id)->whereNotNull('awb_number')->firstOrFail();

        $reqdata = $request->input();

        if($request->status == 'cancelled'){
            $status = (new ShippingAPIHelper())->cancelOrder($order->awb_number);
        }

        // if( ! $status) {
        //     return back()->with('error','Unable to cancel the order');
        // }

        // $order->status = Order::CANCELLED;

        $order->status = $request->status;

        if( ! $order->save()) {
            return back()->with('error','Something went wrong');
        }

        return back()->with('message', 'updated');
    }

    public function getLists()
    {
        $products = DB::table('products')
        ->leftJoin('product_categories', 'products.id', '=', 'product_categories.category_id')
        ->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
        ->leftJoin('product_pack_maps', 'products.id', '=', 'product_pack_maps.product_id')
        ->leftJoin('inventories', 'inventories.product_pack_map_id', '=', 'product_pack_maps.id')
        ->select('products.id','products.name','products.slug','products.thumbnail_image')
        ->where('products.user_diy_pack', '=', 0)
        ->where('products.is_active', '=', 1)
        ->where('inventories.branch_id', '=', Auth::user()->branch_id)
        ->groupByRaw('products.id')
        ->get();

        $productsQty = DB::table('products')
        ->leftJoin('product_categories', 'products.id', '=', 'product_categories.category_id')
        ->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
        ->leftJoin('product_pack_maps', 'products.id', '=', 'product_pack_maps.product_id')
        ->leftJoin('inventories', 'inventories.product_pack_map_id', '=', 'product_pack_maps.id')
        ->select('*')
        ->where('products.user_diy_pack', '=', 0)
        ->where('products.is_active', '=', 1)
        ->where('inventories.branch_id', '=', Auth::user()->branch_id)
        ->get();
        // echo '<pre>';
        // print_r($products);
        // exit;
        return view('admin.product.branch_product', compact('products','productsQty'));
    }


    public function productstock(Request $request){

        // $get_pro_
        $status='';
        $start='';
        $end='';
        $filterType='';
        $selectedBranch= Auth::user()->branch_id;

        $reqdata = $request->input();
        $category_id = isset($reqdata['category_id']) ? $reqdata['category_id'] : '';

            // $selectedBranch=$request->selectedBranch;
            $products = DB::table('products')
            ->leftJoin('product_categories', 'products.id', '=', 'product_categories.category_id')
            ->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
            ->leftJoin('product_pack_maps', 'products.id', '=', 'product_pack_maps.product_id')
            ->leftJoin('inventories', 'inventories.product_pack_map_id', '=', 'product_pack_maps.id')
            ->leftJoin('branches', 'branches.id', '=', 'inventories.branch_id')
            ->select('*','products.name as pro_name','products.slug as pro_slug','products.thumbnail_image as pro_thumb', 'branches.name as br_name','products.id as pro_id')
            ->where('products.user_diy_pack', '=', 0);
            if($request->start != null && $request->end != null){
                $start = $request->start;
                $end = $request->end;

                $products = $products
                            ->whereDate('inventories.created_at', '<=', $end)
                            ->whereDate('inventories.created_at', '>=', $start);
            }
            $products=$products->where('products.user_diy_pack', '=', 0)
            ->where('products.is_active', '=', 1)
            ->where('inventories.branch_id', '=', $selectedBranch)
            ->groupByRaw('products.id')
            ->get();



        if($request->datetime != null){
                    $filterType=$request->datetime;
                }
        $branches = Branch::all();
        $category_data = Category::all();
        return view('admin.report.productstock_cfa', compact('products','selectedBranch','branches','status','filterType','start','end','category_data','category_id'));
    }


}
