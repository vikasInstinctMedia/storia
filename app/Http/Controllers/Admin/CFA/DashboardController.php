<?php

namespace App\Http\Controllers\Admin\CFA;

use Illuminate\Http\Request;
use App\Helpers\ChartDataHelper;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // dd(Auth::user()->branch_id);
        $data['productCount']  = DB::table('products')->count();


        $data['pendingOrders'] = DB::table('orders')
                                ->where('branch_id', Auth::user()->branch_id)
                                ->whereIn('status', ['pending', 'processing'])
                                ->count();
$data['total_orders'] = DB::table('orders')->where('branch_id', Auth::user()->branch_id)->count();

        $data['usersCount']    = DB::table('users')->count();


        $data['branchesCount']    = DB::table('branches')->count();

        // dd($data);
        $data['barChartData']  = ChartDataHelper::getOrderData('month');
        $data['barChartData']  = json_encode($data['barChartData']);
        // dd($data);
        return view('admin.cfa.dashboard', $data);
    }

    public function getDataForChart(Request $request)
    {
        // dd($request->all());
        $data['barChartData'] = ChartDataHelper::getOrderData($request->filterWith);
        // dd($data);
        return $this->successJsonResponse($data);

    }

}
