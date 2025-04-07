<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Menu;
use App\Models\MenuDetails;
use App\Models\Partner;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ManageController extends Controller
{
    public function adminAllMenuDetails()
    {
         $id= Auth::guard('partner')->id();
        $menu_details = MenuDetails::orderBy('id','desc')->get();
        return view('admin.backend.menu_details.all_menu_details', compact('menu_details'));
    }
    //End
    public function adminAddMenuDetials()
    {
        $category= Category::latest()->get();
        $menu= Menu::orderBy('id','desc')->get();
        $city = City::latest()->get();
        $partner = Partner::latest()->get();
        return view('admin.backend.menu_details.add_menu_details',compact('category','menu','city','partner'));
    }
    //End
    public function adminAddMenuDetialsSubmit(Request $request)
    {
        $pCode= IdGenerator::generate(['table'=>'menu_details','field'=>'code','length'=>5,'prefix'=>'BA']);
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_image = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('image/menu_detials/' . $name_image));
            $save_path = 'image/menu_detials/' . $name_image;
            MenuDetails::create([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ','-',$request->name)),
                'category_id' => $request->category_id,
                'menu_id' => $request->menu_id,
                'city_id' => $request->city_id,
                'partner_id' =>$request->partner_id,
                'code' => $pCode,
                'qty' => $request->qty,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'size' => $request->size,
                'status' => '1',
                'image' => $save_path,
                'created_at' => Carbon::now(),
            ]);
            $notifiaction = array(
                'message' => 'Menu Detials Saved Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.all_menu_details')->with($notifiaction);
        }
    }
    //End
    public function adminEditMenuDetials($id)
    {
        $category= Category::latest()->get();
        $menu= Menu::orderBy('id','desc')->get();
        $city = City::latest()->get();
        $menuDetials= MenuDetails::find($id);
        $partner = Partner::latest()->get();
        return view('admin.backend.menu_details.edit_menu_details',compact('category','menu','city','menuDetials','partner'));
    }
    //End
    public function adminEditMenuDetialsSubmit(Request $request){
       
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_image = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('image/menu_detials/' . $name_image));
            $save_path = 'image/menu_detials/' . $name_image;
            MenuDetails::find($request->id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ','-',$request->name)),
                'category_id' => $request->category_id,
                'menu_id' => $request->menu_id,
                'city_id' => $request->city_id,
                'qty' => $request->qty,
                'price' => $request->price,
                'partner_id'=> $request->partner_id,
                'discount_price' => $request->discount_price,
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'size' => $request->size,
                'image' => $save_path,
                'created_at' => Carbon::now(),
            ]);
            $notifiaction = array(
                'message' => 'Menu Detials Saved Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.all_menu_details')->with($notifiaction);
        }else{
            MenuDetails::find($request->id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ','-',$request->name)),
                'category_id' => $request->category_id,
                'menu_id' => $request->menu_id,
                'city_id' => $request->city_id,
                'qty' => $request->qty,
                'price' => $request->price,
                'partner_id'=> $request->partner_id,
                'discount_price' => $request->discount_price,
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'size' => $request->size,
                'created_at' => Carbon::now(),
            ]);
            $notifiaction = array(
                'message' => 'Menu Detials Saved Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.all_menu_details')->with($notifiaction);
        }
    }
    //End
    public function adminDeleteMenuDetials($id){
        $menu_detials = MenuDetails::find($id);
        unlink($menu_detials->image);
        $menu_detials = MenuDetails::find($id)->delete();
        $notifiaction = array(
            'message' => 'Menu Detials Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notifiaction);
    }
    //End
    ////////////////////////////  Pending Active Restaurant   /////////////////////////////
    public function pendingRestaurant(){
        $partner= Partner::where('status',0)->get();
        return view('admin.backend.restaurant.pending_restaurant',compact('partner'));

    }
    //End
    public function changeRestaurantStatus(Request $request){
        $partner=Partner::find($request->detials_id);
        $partner->status=$request->status;
        $partner->save();
        return response()->json(['success'=>'Status change successfuly']);
    }
    //End
    public function activeRestaurant(){
        $partner= Partner::where('status',1)->get();
        return view('admin.backend.restaurant.active_restaurant',compact('partner'));

    }
    //End
}
