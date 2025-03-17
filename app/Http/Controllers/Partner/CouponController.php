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
        $id= Auth::guard('partner')->id();
        $coupon = Coupon::where('partner_id',$id)->orderBy('id','desc')->get();
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
    public function EditCoupon($id){
        $coupon=Coupon::find($id);
        return view('partner.backend.coupon.edit_coupon',compact('coupon'));
    }
    //End
    public function updateCoupon(Request $request){
        $coup_id= $request->id;
        Coupon::find($request->id)->update([
            'coupon_name' =>strtoupper( $request->coupon_name),
            'coupon_desc' => $request->coupon_desc,
            'discount' => $request->discount,
            'validity' => $request->validity,
        ]);
        $notifiaction = array(
            'message' => 'Coupon Update Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('coupon.all')->with($notifiaction);
    }
    //End
    public function deleteCoupon($id){
    
        $coupon = Coupon::find($id)->delete();
        $notifiaction = array(
            'message' => 'Coupon Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notifiaction);
    }
}
