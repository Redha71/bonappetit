<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class MenuController extends Controller
{

    public function partnerAllMenu()
    {
        $menu = Menu::latest()->get();
        return view('partner.backend.menu.all_menu', compact('menu'));
    }
    //End
    public function partnerAddMenu()
    {
        return view('partner.backend.menu.add_menu');
    }
    //End
    public function partnerAddMenuSubmit(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_image = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('image/menu_image/' . $name_image));
            $save_path = 'image/menu_image/' . $name_image;
            Menu::create([
                'menu_name' => $request->menu_name,
                'image' => $save_path
            ]);
            $notifiaction = array(
                'message' => 'Menu Saved Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('partner.all_menu')->with($notifiaction);
        }
    }
    //End
    public function partnerEditMenu($id)
    {
        $menu = Menu::find($id);
        return view('partner.backend.menu.edit_menu', compact('menu'));
    }
    //End
    public function partnerEditMenuSubmit(Request $request)
    {
        $menu = Menu::find($request->id);
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_image = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('image/menu_image/' . $name_image));
            $save_path = 'image/menu_image/' . $name_image;
            Menu::find($request->id)->update([
                'menu_name' => $request->menu_name,
                'image' => $save_path
            ]);
            $this->oldImageDelete($menu->image);

            $notifiaction = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('partner.all_menu')->with($notifiaction);
        }else{
            Menu::find($request->id)->update([
                'menu_name' => $request->menu_name,
            ]);
            $notifiaction = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('partner.all_menu')->with($notifiaction);
        }
    }
    //End
    private function oldImageDelete($oldImage): void
    {
        $path = public_path($oldImage);
        unlink($path);
    }
    //End
    public function partnerDeleteMenu($id){
        $menu = Menu::find($id);
        unlink($menu->image);
        $menu = Menu::find($id)->delete();
        $notifiaction = array(
            'message' => 'Menu Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notifiaction);
    }
}
