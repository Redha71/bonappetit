<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Menu;
use App\Models\MenuDetails;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class MenuDetailsController extends Controller
{
    public function partnerAllMenuDetails()
    {
        $menu_details = MenuDetails::latest()->get();
        return view('partner.backend.menu_details.all_menu_details', compact('menu_details'));
    }
    //End
    public function partnerAddMenuDetials()
    {
        $category= Category::latest()->get();
        $menu= Menu::latest()->get();
        $city = City::latest()->get();
        return view('partner.backend.menu_details.add_menu_details',compact('category','menu','city'));
    }
    //End
    public function partnerAddMenuDetialsSubmit(Request $request)
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
                'partner_id' => Auth::guard('partner')->id(),
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
            return redirect()->route('partner.all_menu_details')->with($notifiaction);
        }
    }
    //End
    public function partnerEditMenuDetials($id)
    {
        $category= Category::latest()->get();
        $menu= Menu::latest()->get();
        $city = City::latest()->get();
        $menuDetials= MenuDetails::find($id);
        return view('partner.backend.menu_details.edit_menu_details',compact('category','menu','city','menuDetials'));
    }
    //End
    public function partnerEditMenuDetialsSubmit(Request $request){
       
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
            return redirect()->route('partner.all_menu_details')->with($notifiaction);
        }else{
            MenuDetails::find($request->id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ','-',$request->name)),
                'category_id' => $request->category_id,
                'menu_id' => $request->menu_id,
                'city_id' => $request->city_id,
                'qty' => $request->qty,
                'price' => $request->price,
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
            return redirect()->route('partner.all_menu_details')->with($notifiaction);
        }
    }
    //End
    public function partnerDeleteMenuDetials($id){
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
    public function changeStatus(Request $request){
        $menu_detials= MenuDetails::find($request->detials_id);
        $menu_detials->status=$request->status;
        $menu_detials->save();
        return response()->json(['success'=>'Status change successfuly']);
    }
    //End
}
