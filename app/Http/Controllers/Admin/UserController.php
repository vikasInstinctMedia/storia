<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Review;
use App\Models\Review_reply;
use App\Http\Requests\Admin\ProductRequest;
use DB;
use App\Models\Category;
use App\Models\EmailSubscription;
use App\Models\Inventory;
use App\Models\Pack;
use App\Models\ProductPackMap;
use App\Traits\ProductHelperTrait;
use Storage;
use File;
use Auth;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function getList()
    {
        $users = User::withCount('orders')->latest();

        // dd($allBranchProducts->get());
        return datatables()->of($users)
                    ->addIndexColumn()
                    // ->editColumn('thumbnail_image', function($row) {
                    //     return $row->thumbnail_image ? asset("storage/".$row->thumbnail_image) : "";
                    // })
                    ->addColumn('action', function($row){
                           return [
                                // 'view_url' => route('admin.categories.show',[ 'category' => $row->id]),
                                'edit_url' => route('admin.products.edit', ['product' => $row->id])
                           ];
                    })
                    ->toJson();
    }

    public function create()
    {
        return view('admin.branch.add');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function update(Request $request)
    {

    }

    public function distroy()
    {

    }

    public function show()
    {

    }


    public function customers(Request $request){
        $status='';
        $start='';
        $end='';
        $filterType='';
        $name='';
        $user_id = '';
        $users = User::withCount('orders')->latest();
                if ($request->status != null){
                    $status = $request->status;
                    $users = $users->where('status', $status);

                }
                if ($request->start != null && $request->end != null){
                    $start = $request->start;
                    $end = $request->end;

                    $users = $users
                                ->whereDate('created_at', '<=', $end)
                                ->whereDate('created_at', '>=', $start);

                }
                if($request->datetime != null){
                    $filterType=$request->datetime;
                }
                if($request->name != null){
                    $name=$request->name;
                    $users->where('name', 'like', '%' . $name . '%');
                }
        $users = $users->get();

        return view('admin.report.customerReport', compact('users','status','filterType','start','end','name'));

    }
    public function updateCustomer(Request $request){
        $rules = [
            'custname'   => 'required',
            'email'   => 'required|email',
            ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
        return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $user = User::findOrFail($request->customerId);
        $user->name = $request->custname;
        $user->email  = $request->email;
        if($request->pass!=null){
             $user->password=bcrypt($request->pass);
        }
        $user->save();
        return redirect()->route('admin.customers');
    }

    public function allcustOrder($id){
        $selectedBranch='';
        $status='';
        $start='';
        $end='';
        $filterType='';
        $orders = Order::with('user','branch')->where('subscription_order',0)
                ->orderBy('created_at', 'desc')
                ->where('user_id',$id);
                // if ($request->start != null && $request->end != null){
                //     $start = $request->start;
                //     $end = $request->end;

                //     $orders = $orders
                //                 ->whereDate('created_at', '<=', $end)
                //                 ->whereDate('created_at', '>=', $start);

                // }
                // if($request->datetime != null){
                //     $filterType=$request->datetime;
                // }

                $orders = $orders->latest()->get()->append('products');
                $id=$id;
                $branches = Branch::all();
        return view('admin.report.customerOrderdetails', compact('branches','id','orders','selectedBranch','status','filterType','start','end'));
    }

    public function allcustOrderfilter(Request $request){
        $id=$request->id;
        $selectedBranch='';
        $status='';
        $start='';
        $end='';
        $filterType='';
        $orders = Order::with('user','branch')->where('subscription_order',0)
                ->orderBy('created_at', 'desc')
                ->where('user_id',$id);
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
                $id=$id;
                $branches = Branch::all();
        return view('admin.report.customerOrderdetails', compact('branches','id','orders','selectedBranch','status','filterType','start','end'));
    }

    public function reviewReport(Request $request){
        $id=$request->id;
        $selectedBranch='';
        $status='';
        $start='';
        $end='';
        $filterType='';

        $reqdata = $request->input();
        $user_id = isset($reqdata['user_id']) ? $reqdata['user_id'] : '';
        $Review = Review::orderBy('created_at', 'desc');
                if ($request->start != null && $request->end != null){
                    $start = $request->start;
                    $end = $request->end;

                    $Review = $Review
                                ->whereDate('created_at', '<=', $end)
                                ->whereDate('created_at', '>=', $start);

                }
                if($request->datetime != null){
                    $filterType=$request->datetime;
                }

                if($user_id != ''){
                    $Review->where('user_id', '=', $user_id);
                }

                $Review = $Review->latest()->get();
                $id=$id;
                $branches = Branch::all();
        return view('admin.report.reviewReport', compact('branches','id','Review','selectedBranch','status','filterType','start','end'));
    }

    public function reviewReplyAdd(Request $request){
        $review=new Review_reply();
        $review->review_id=$request->revieId;
        $review->reply=$request->reply;
        $review->save();
        return back();
    }

    public function reviewStatusupdate(Request $request){
        $review = Review::findOrFail($request->reivewId);
        $review->status = $request->status;
        $review->status_comment=$request->status_comment;
        $review->save();
        return back();
    }

    public function Transactional(Request $request){
        $status='';
        $start='';
        $end='';
        $filterType='';
        $selectedBranch='';
        $users = Order::with('user','branch');
                if ($request->selectedBranch!=null){
                    $selectedBranch=$request->selectedBranch;
                    $users = $users->where('branch_id', $selectedBranch);

                }
                if ($request->status != null){
                    $status = $request->status;
                    $users = $users->where('status', $status);

                }
                if ($request->start != null && $request->end != null){
                    $start = $request->start;
                    $end = $request->end;

                    $users = $users
                                ->whereDate('created_at', '<=', $end)
                                ->whereDate('created_at', '>=', $start);

                }
                if($request->datetime != null){
                    $filterType=$request->datetime;
                }
        $branches = Branch::all();
        $users = $users->latest()->get()->append('user');
        return view('admin.report.transactional', compact('users','selectedBranch','branches','status','filterType','start','end'));
    }

    public function productstock(Request $request){

        // $get_pro_
        $status='';
        $start='';
        $end='';
        $filterType='';
        $selectedBranch='';
        $reqdata = $request->input();
        $category_id = isset($reqdata['category_id']) ? $reqdata['category_id'] : '';
        if($request->selectedBranch==null){
            $products = DB::table('products')
            ->leftJoin('product_categories', 'products.id', '=', 'product_categories.category_id')
            ->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
            ->leftJoin('product_pack_maps', 'products.id', '=', 'product_pack_maps.product_id')
            ->leftJoin('inventories', 'inventories.product_pack_map_id', '=', 'product_pack_maps.id')
            ->leftJoin('branches', 'branches.id', '=', 'inventories.branch_id')
            ->select('*','products.name as pro_name','products.slug as pro_slug','products.thumbnail_image as pro_thumb', 'branches.name as br_name','products.id as pro_id',DB::raw("(SELECT SUM(quantity) FROM inventories
            WHERE inventories.product_pack_map_id = product_pack_maps.id
            GROUP BY product_pack_maps.product_id) as finalQty"))
            ->where('products.user_diy_pack', '=', 0);
            if($request->start != null && $request->end != null){
                $start = $request->start;
                $end = $request->end;

                $products = $products
                            ->whereDate('inventories.created_at', '<=', $end)
                            ->whereDate('inventories.created_at', '>=', $start);
            }
            // if($category_id != ''){
            //     $products->where('categories.id' , $category_id);
            // }
            $products=$products->where('products.is_active', '=', 1)
            ->groupByRaw('products.id')
            ->get();

        }else if($request->selectedBranch!=null){
            $selectedBranch=$request->selectedBranch;
            $products = DB::table('products')
            ->leftJoin('product_categories', 'products.id', '=', 'product_categories.category_id')
            ->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
            ->leftJoin('product_pack_maps', 'products.id', '=', 'product_pack_maps.product_id')
            ->leftJoin('inventories', 'inventories.product_pack_map_id', '=', 'product_pack_maps.id')
            ->leftJoin('branches', 'branches.id', '=', 'inventories.branch_id')
            ->select('*','products.name as pro_name','products.slug as pro_slug','products.thumbnail_image as pro_thumb' , 'branches.name as br_name' ,'products.id as pro_id')
            ->where('products.user_diy_pack', '=', 0);
            if($request->start != null && $request->end != null){
                $start = $request->start;
                $end = $request->end;

                $products = $products
                            ->whereDate('inventories.created_at', '<=', $end)
                            ->whereDate('inventories.created_at', '>=', $start);
            }
            // if($category_id != ''){
            //     $products->where('product_categories.category_id' , $category_id);
            // }
            $products=$products->where('products.user_diy_pack', '=', 0)
            ->where('products.is_active', '=', 1)
            ->where('inventories.branch_id', '=', $selectedBranch)
            ->groupByRaw('products.id')
            ->get();
        }


        if($request->datetime != null){
                    $filterType=$request->datetime;
                }
        $branches = Branch::all();
        $category_data = Category::all();
        return view('admin.report.productstock', compact('products','selectedBranch','branches','status','filterType','start','end','category_data','category_id'));
    }

    public function product_export(Request $request){
        $category_id = isset($reqdata['category_id']) ? $reqdata['category_id'] : '';
        if($request->selectedBranch==null){
            $products = DB::table('products')
            ->leftJoin('product_categories', 'products.id', '=', 'product_categories.category_id')
            ->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
            ->leftJoin('product_pack_maps', 'products.id', '=', 'product_pack_maps.product_id')
            ->leftJoin('inventories', 'inventories.product_pack_map_id', '=', 'product_pack_maps.id')
            ->leftJoin('branches', 'branches.id', '=', 'inventories.branch_id')
            ->select('*','products.name as pro_name','products.slug as pro_slug','products.thumbnail_image as pro_thumb', 'branches.name as br_name','products.id as pro_id',DB::raw("(SELECT SUM(quantity) FROM inventories
            WHERE inventories.product_pack_map_id = product_pack_maps.id
            GROUP BY product_pack_maps.product_id) as finalQty"))
            ->where('products.user_diy_pack', '=', 0);
            $products=$products->where('products.is_active', '=', 1)
            ->groupByRaw('products.id')
            ->get();

        }else if($request->selectedBranch!=null){
            $selectedBranch=$request->selectedBranch;
            $products = DB::table('products')
            ->leftJoin('product_categories', 'products.id', '=', 'product_categories.category_id')
            ->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
            ->leftJoin('product_pack_maps', 'products.id', '=', 'product_pack_maps.product_id')
            ->leftJoin('inventories', 'inventories.product_pack_map_id', '=', 'product_pack_maps.id')
            ->leftJoin('branches', 'branches.id', '=', 'inventories.branch_id')
            ->select('*','products.name as pro_name','products.slug as pro_slug','products.thumbnail_image as pro_thumb' , 'branches.name as br_name' ,'products.id as pro_id',)
            ->where('products.user_diy_pack', '=', 0);
            $products=$products->where('products.user_diy_pack', '=', 0)
            ->where('products.is_active', '=', 1)
            ->where('inventories.branch_id', '=', $selectedBranch)
            ->groupByRaw('products.id')
            ->get();
        }

        $branches = Branch::all();
        $category_data = Category::all();
        return view('admin.report.product_export', compact('products','branches','category_data','category_id'));
    }

    public function  delete_customer($id){
    //    dd($id);
       if (!User::where('id', $id)->delete()) {
        return back()->with('error', 'Failed');
    }

    return back()->with('message', 'Deleted');
    }

    public function review_delete(Request $request){

        $req_data = $request->input();
        $id = isset($req_data['id']) ? $req_data['id'] : '';

        if (!Review::where('id', $id)->delete()) {
            return back()->with('error', 'Failed');
        }

        return back()->with('message', 'Deleted');
    }

    public function delete_reply(Request $request){
        $req_data = $request->input();
        $id = isset($req_data['id']) ? $req_data['id'] : '';

        if (!Review_reply::where('id', $id)->delete()) {
            return back()->with('error', 'Failed');
        }

        return back()->with('message', 'Deleted');
    }

    public function get_all_sub_users_email(){
        $get_data = EmailSubscription::get();
        return view('admin.user.email_subs',compact('get_data'));
    }

    public function delete_sub($id){
        if (!EmailSubscription::where('id', $id)->delete()) {
            return back()->with('error', 'Failed');
        }

        return back()->with('message', 'Deleted');
    }

}
