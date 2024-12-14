<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Siteemail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
  public function adminLogin()
  {
    return view('admin.login');
  }
  //End
  public function adminDashboard()
  {
    return view('admin.index');
  }
  //End
  public function adminLoginSubmit(Request $request)
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
    if (Auth::guard('admin')->attempt($data)) {
      $notifiaction = array(
        'message'=> 'Login Successfully',
        'alert-type'=> 'success'
      );
      return redirect()->route('admin.dashboard')->with($notifiaction );
    } else {
      $notifiaction = array(
        'message'=> 'username or password not currect',
        'alert-type'=> 'error'
      );
      return redirect()->route('admin.login')->with($notifiaction);
    }
  }
  //End
  public function adminLogout()
  {
    Auth::guard('admin')->logout();
    return redirect()->route('admin.login')->with('success', 'Logout Successfully');
  }
  //End
  public function adminForgetPassword()
  {
    return view('admin.forget_password');
  }
  //End
  public function adminForgetSubmit(Request $request)
  {
    $request->validate([
      'email'=>'required|email'
    ]);
    $adminData = Admin::where('email',$request->email)->first();
    if(!$adminData){
      return redirect()->back()->with('error','Email Not Found');
    }
    $token = hash('sha256',time());
    $adminData->token=$token ;
    $adminData->update();
    $resetLink= url('admin/reset_link/'.$token.'/'.$request->email);
    $subject= 'Reset Password';
    $message='You are receiving this email because we received a password reset request for your account.';
    $message.='<a href="'.$resetLink.'">Click The Link</a>';
    Mail::to($request->email)->send(new Siteemail($subject, $message));
    return redirect()->back()->with('success','Check your email for reset Password link');
  }
  //End
  public function adminResetPassword($token,$email){
    $adminData = Admin::where('email',$email)->where('token',$token)->first();
    if(!$adminData){
      return redirect()->back()->with('error','Email or token not correct');
    }
    return view('admin.reset_password',compact('token','email'));
  }
  //End
  public function adminResetPasswordSubmit(Request $request){
    $request->validate([
      'password'=>'required',
      'password_confirmation' =>'required|same:password'
    ]);
    $adminData = Admin::where('email',$request->email)->where('token',$request->token)->first();
    $adminData->password = Hash::make($request->password);
    $adminData->token = "";
    $adminData->update();
    return redirect()->route('admin.login')->with('success','Password Reset');

  }
  //End
  public function adminProfile(){
    $id= Auth::guard('admin')->id();
    $profile_data= Admin::find($id);
    return view('admin.admin_profile',compact('profile_data'));
  }
  //End
  public function adminProfileEdit(Request $request){
    $id= Auth::guard('admin')->id();
    $profile_data= Admin::find($id);
    $profile_data->name = $request->name;
    $profile_data->email= $request->email;
    $profile_data->phone = $request->phone;
    $profile_data->address = $request->address;
    $oldImage = $profile_data->image;  
    if($request->hasFile('image')){
      $file= $request->file('image');
      $file_name= time().'.'.$file->getClientOriginalExtension();
      $file->move(public_path('image/backend_image'), $file_name);
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
    $path = public_path('image/backend_image/'.$oldImage);
    unlink($path);
  }
  //End
  public function adminProfileChangePassword(){
    $id= Auth::guard('admin')->id();
    $profile_data= Admin::find($id);
    return view('admin.admin_profile_change_password',compact('profile_data'));
  }
  //End

  public function adminPasswordChange(Request $request){
    $id= Auth::guard('admin')->id();
    $profile_data= Admin::find($id);
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
    Admin::whereId($id)->update([
      'password'=>Hash::make($request->new_password)
    ]);
    $notifiaction = array(
      'message'=> 'The Password is change',
      'alert-type'=> 'success'
    );
    return back()->with($notifiaction );
  }


}
