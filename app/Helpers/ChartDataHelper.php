<?php

namespace App\Helpers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ChartDataHelper {

    
    /**
     *  $for value accepts month, week, day
     *  units maximum assumed is 7
     */
    public static function getOrderData($for, $dateFrom = '' , $dateTill = '') : array
    {
        
        // 1. Fetching data
        switch ($for) {
            case 'month':
                $groupByColumn = DB::raw('month(created_at) as '.$for);
                break;
            case 'week':
                $groupByColumn = DB::raw('week(created_at) as '.$for);
                break;
            case 'day':
                $groupByColumn = DB::raw('date(created_at) as '.$for);
                break;
            default:
                # code...
                break;
        }

        $rawData = DB::table('orders')
                  ->select(
                        $groupByColumn, 
                        DB::raw('COUNT(created_at) as order_count'),
                        DB::raw('COUNT(order_products.order_id) as sku_count') 
                    )
                  ->leftJoin('order_products', 'orders.id', 'order_products.order_id')

                  //->where('status', Order::COMPLETED)
                  ->when(auth()->user()->branch_id  , function ($query, $branchId) {
                    return $query->where('branch_id', $branchId);
                  })
                  ->groupBy(DB::raw($for))
                  ->get();
        

        // 2. Formating data
        
        $orderChartData = [];

        foreach($rawData as $key => $value) {
            $methodName = 'labelFor'.ucfirst($for);
            $orderChartData['labels'][$key] =  self::$methodName($value);
            $orderChartData['orders_count'][$key] = $value->order_count;
            $orderChartData['sku_count'][$key] = $value->sku_count;
            // dump($orderChartData);
        }
        // dd( $orderChartData );

        return $orderChartData;
    }

    private static function labelForMonth($value)
    {
        return Carbon::create()->month($value->month)->format('F');
    }

    private static function labelForWeek($value)
    {
        $date = Carbon::now();
        $date->setISODate(2021,$value->week);
        // dd( $date->startOfWeek() );
        return $date->startOfWeek()->format('d-m'). ' - '. $date->endOfWeek()->format('d-m');
    }

    private static function labelForDay($value)
    {
        return Carbon::parse($value->day)->format('d-m');
    }
}