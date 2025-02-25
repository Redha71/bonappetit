<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function allCoupon()
    {
        $coupon = Coupon::latest()->get();
        return view('partner.backend.coupon.all_coupon', compact('coupon'));
    }
    //End
    public function addCoupon()
    {
        return view('partner.backend.coupon.add_coupon');
    }
    //End
    public function addCouponSubmit(Request $request)
    {

            Coupon::create([
                'coupon_name' =>strtoupper( $request->coupon_name),
                'partner_id' => Auth::guard('partner')->id(),
                'coupon_desc' => $request->coupon_desc,
                'discount' => $request->discount,
                'validity' => $request->validity,
                'created_at' => Carbon::now(),
            ]);
            $notifiaction = array(
                'message' => 'Coupon Saved Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('coupon.all')->with($notifiaction);
        
    }
    //End
}
