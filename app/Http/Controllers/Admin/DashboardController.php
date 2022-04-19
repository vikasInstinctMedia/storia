<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Helpers\ChartDataHelper;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Tags;
use DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['productCount']  = DB::table('products')->count();
        if(auth()->user()->roleIs('branch_admin'))
        {
            $orders = Order::with('user','branch')
            ->orderBy('created_at', 'desc');
            if(Auth::user()->branch_id!=""){
                $orders = $orders->where('branch_id', Auth::user()->branch_id);
            }
            $data['pendingOrders'] = $orders->count();
            $data['total_orders'] = DB::table('orders')->where('branch_id', Auth::user()->branch_id)->count();
            $data['last_order'] = Order::with('user','branch')->orderBy('id','desc')->where('branch_id', Auth::user()->branch_id)->first();

        }else{
            $data['total_orders'] = DB::table('orders')->count();
            $data['pendingOrders'] = DB::table('orders')->whereIn('status', ['pending'])->count();
            $data['last_order'] = Order::with('user','branch')->orderBy('id','desc')->first();
        }

        $data['usersCount']    = DB::table('users')->count();
        $data['branchesCount']    = DB::table('branches')->count();

        $data['barChartData']  = ChartDataHelper::getOrderData('month');
        $data['barChartData']  = json_encode($data['barChartData']);
        // dd($data);

        //stocks
        if(auth()->user()->roleIs('branch_admin')){
            $prostock = Inventory::where('branch_id',Auth::user()->branch_id)->sum('quantity');
        }else{
            $prostock = Inventory::sum('quantity');
        }

        if(auth()->user()->roleIs('branch_admin')){
            $prosold = Order::where('branch_id',Auth::user()->branch_id)->sum('totalQty');
        }else{
            $prosold = Order::sum('totalQty');
        }

        $data['prostock'] = $prostock;
        $data['prosold'] = $prosold;

        //stocks ends here
        return view('admin.dashboard', $data);
    }

    public function getDataForChart(Request $request)
    {
        // dd($request->all());
        $data['barChartData'] = ChartDataHelper::getOrderData($request->filterWith);
        return $this->successJsonResponse($data);

    }

    public function get_tags_suggestions(Request $request){
        $req_data = $request->input();
        $term = isset($req_data['term']) ? $req_data['term'] : '';
        $get_sugg = Tags::where('status',1)->where('tag', 'like', '%' . $term . '%')->get();
        $tag_array = [];
        foreach ($get_sugg as $key => $value) {
            array_push($tag_array,$value->tag);
        }

      $final_array = array("suggestions" => $tag_array);
      return $final_array;
    }

}
