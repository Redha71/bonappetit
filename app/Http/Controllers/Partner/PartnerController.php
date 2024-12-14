<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Siteemail;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function partnerLogin()
    {
        return view('partner.login');
    }
    //End
    public function partnerRegister()
    {
        return view('partner.register');
    }
    //End
    public function partnerRegisterSubmit(Request $request)
    {
        $request->validate([
            'email' => ['required', 'unique:partners'],
            'name' => ['required', 'max:250'],
        ]);
        Partner::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'partner',
            'status' => '0',
            'password' => Hash::make($request->address),
        ]);
        $notifiaction = array(
            'message' => 'Partner is register successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('partner.login')->with($notifiaction);
    }
    //End
    public function partnerForgetPassword()
    {
        return view('partner.forget_password');
    }
    //End
    public function partnerForgetSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $partnerData = Partner::where('email', $request->email)->first();
        if (!$partnerData) {
            $notifiaction = array(
                'message' => 'Email Not Found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notifiaction);
        }
        $token = hash('sha256', time());
        $partnerData->token = $token;
        $partnerData->update();
        $resetLink = url('partner/reset_link/' . $token . '/' . $request->email);
        $subject = 'Reset Password';
        $message = 'You are receiving this email because we received a password reset request for your account.';
        $message .= '<a href="' . $resetLink . '">Click The Link</a>';
        Mail::to($request->email)->send(new Siteemail($subject, $message));
        $notifiaction = array(
            'message' => 'Check your email for reset Password link',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notifiaction);
    }
    //End
    public function partnerResetPassword($token, $email)
    {
        $partnerData = Partner::where('email', $email)->where('token', $token)->first();
        if (!$partnerData) {
            $notifiaction = array(
                'message' => 'Email or token not correct',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notifiaction);
        }

        return view('partner.reset_password', compact('token', 'email'));
    }
    //End
    public function partnerResetPasswordSubmit(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);
        $partnerData = Partner::where('email', $request->email)->where('token', $request->token)->first();
        $partnerData->password = Hash::make($request->password);
        $partnerData->token = "";
        $partnerData->update();
        $notifiaction = array(
            'message' => 'Password Reset successfuly',
            'alert-type' => 'success'
        );
        return redirect()->route('partner.login')->with($notifiaction);
    }
    //End
    public function partnerLoginSubmit(Request $request)
    {
      $request->validate([
        'email' => 'required|email',
        'password' =>  'required',
      ]);
      $getData = $request->all();
      $data = [
        'email' => $getData['email'],
        'password' => $getData['password'],
      ];
      if (Auth::guard('partner')->attempt($data)) {
        $notifiaction = array(
          'message'=> 'Login Successfully',
          'alert-type'=> 'success'
        );
        return redirect()->route('partner.dashboard')->with($notifiaction );
      } else {
        $notifiaction = array(
          'message'=> 'username or password not currect',
          'alert-type'=> 'error'
        );
        return redirect()->route('partner.login')->with($notifiaction);
      }
      
    }
    //End
    public function partnerDashboard()
  {
    return view('partner.index');
  }
  //End
  public function partnerLogout()
  {
    Auth::guard('partner')->logout();
    $notifiaction = array(
        'message'=> 'Logout Successfully',
        'alert-type'=> 'success'
      );
    return redirect()->route('partner.login')->with($notifiaction);
  }
  //End
  public function partnerProfile(){
    $id= Auth::guard('partner')->id();
    $profile_data= Partner::find($id);
    return view('partner.partner_profile',compact('profile_data'));
  }
  //End
  public function partnerProfileEdit(Request $request){
    $id= Auth::guard('partner')->id();
    $profile_data= Partner::find($id);
    $profile_data->name = $request->name;
    $profile_data->email= $request->email;
    $profile_data->phone = $request->phone;
    $profile_data->address = $request->address;
    $oldImage = $profile_data->image;  
    if($request->hasFile('image')){
      $file= $request->file('image');
      $file_name= time().'.'.$file->getClientOriginalExtension();
      $file->move(public_path('image/Partner_image'), $file_name);
      $profile_data->image = $file_name;
      if($oldImage && $oldImage !== $file_name){
        $this->oldImageDelete($oldImage);
      }

      

    }
    $profile_data->save();
    $notifiaction = array(
      'message'=> 'Profile ubdate Successfuly',
      'alert-type'=> 'success'
    );
    return redirect()->back()->with($notifiaction );
    

  }
  //End
  private function oldImageDelete($oldImage): void{
    $path = public_path('image/partner_image/'.$oldImage);
    unlink($path);
  }
  //End
  public function partnerProfileChangePassword(){
    $id= Auth::guard('partner')->id();
    $profile_data= Partner::find($id);
    return view('partner.partner_profile_change_password',compact('profile_data'));
  }
  //End
  public function partnerPasswordChange(Request $request){
    $id= Auth::guard('partner')->id();
    $profile_data= Partner::find($id);
    $request->validate([
      'old_password'=>'required',
      'new_password' =>'required|same:new_password_confirm'
    ]);
    if(!Hash::check($request->old_password,$profile_data->password)){
      $notifiaction = array(
        'message'=> 'The old password is not match',
        'alert-type'=> 'error'
      );
      return back()->with($notifiaction );
    }
    Partner::whereId($id)->update([
      'password'=>Hash::make($request->new_password)
    ]);
    $notifiaction = array(
      'message'=> 'The Password is change',
      'alert-type'=> 'success'
    );
    return back()->with($notifiaction );
  }

}
