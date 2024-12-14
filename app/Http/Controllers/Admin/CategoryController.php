<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class CategoryController extends Controller
{
    public function adminAllCategory(){
        $category= Category::latest()->get();
        return view('admin.backend.category.all_category',compact('category'));
    }
    public function adminAddCategory(){
        return view('admin.backend.category.add_category');
    }
    public function adminAddCategorySubmit(Request $request){
        if($request->file('image')){
            $image= $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_image= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img= $manager->read($image);
            $img->resize(300,300)->save(public_path('image/category_image/'.$name_image));
            $save_path= 'image/category_image/'.$name_image;
            Category::create([
                'category_name' => $request->category_name,
                'image' => $save_path
            ]);
            $notifiaction = array(
                'message'=> 'Category Saved Successfully',
                'alert-type'=> 'success'
              );
              return redirect()->route('admin.all_category')->with($notifiaction );

        }
    }
}
