<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userProfileEdit(Request $request){
        $id= Auth::user()->id;
        $profile_data= User::find($id);
        $profile_data->name = $request->name;
        $profile_data->email= $request->email;
        $profile_data->phone = $request->phone;
        $profile_data->address = $request->address;
        $oldImage = $profile_data->image;  
        if($request->hasFile('image')){
          $file= $request->file('image');
          $file_name= time().'.'.$file->getClientOriginalExtension();
          $file->move(public_path('image/user_image'), $file_name);
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
        $path = public_path('image/user_image/'.$oldImage);
        unlink($path);
      }
      //End
      public function userLogout()
  {
    Auth::guard('web')->logout();
    $notifiaction = array(
        'message'=> 'Logout Successfully',
        'alert-type'=> 'success'
      );
    return redirect()->route('login')->with($notifiaction);
  }
  //End
  public function userProfileChangePassword(){
    $id= Auth::guard('web')->id();
    $profile_data= User::find($id);
    return view('frontend.user.user_profile_change_password',compact('profile_data'));
  }
  //End
  public function userPasswordChange(Request $request){
    $id= Auth::guard('web')->id();
    $profile_data= User::find($id);
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
    User::whereId($id)->update([
      'password'=>Hash::make($request->new_password)
    ]);
    $notifiaction = array(
      'message'=> 'The Password is change',
      'alert-type'=> 'success'
    );
    return back()->with($notifiaction );
  }
}
