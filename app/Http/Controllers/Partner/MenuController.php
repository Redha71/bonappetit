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
}
