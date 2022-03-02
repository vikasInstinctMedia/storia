<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CouponRequest;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupon.add');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        if( ! Coupon::create($data) ) {
            return back()->with('error', 'Failed');
        }
        return redirect()->route('admin.coupons.index')->with('message', 'Created');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupon.edit', compact('coupon'));
    }

    public function update(Request $request)
    {
        $couponData = $request->only('code', 'type', 'value', 'description', 'valid_from','valid_till');
        // print_r($couponData);
        $coupon =  Coupon::where('id', $request->coupon_id)->update($couponData);
        return redirect()->route('admin.coupons.index')->with('message', 'Updated');
    }

    public function destroy(Coupon $coupon)
    {
        if(!$coupon->delete()) {
            return back()->with('error', 'failed');
        }
        return back()->with('message', 'Deleted');
    }

    public function show()
    {
        echo 'asd';
    }

}
