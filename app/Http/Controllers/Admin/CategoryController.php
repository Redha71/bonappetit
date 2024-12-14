<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function adminAllCategory()
    {
        $category = Category::latest()->get();
        return view('admin.backend.category.all_category', compact('category'));
    }
    //End
    public function adminAddCategory()
    {
        return view('admin.backend.category.add_category');
    }
    //End
    public function adminAddCategorySubmit(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_image = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('image/category_image/' . $name_image));
            $save_path = 'image/category_image/' . $name_image;
            Category::create([
                'category_name' => $request->category_name,
                'image' => $save_path
            ]);
            $notifiaction = array(
                'message' => 'Category Saved Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.all_category')->with($notifiaction);
        }
    }
    //End
    public function adminEditCategory($id)
    {
        $category = Category::find($id);
        return view('admin.backend.category.edit_category', compact('category'));
    }
    //End
    public function adminEditCategorySubmit(Request $request)
    {
        $category = Category::find($request->id);
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_image = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('image/category_image/' . $name_image));
            $save_path = 'image/category_image/' . $name_image;
            Category::find($request->id)->update([
                'category_name' => $request->category_name,
                'image' => $save_path
            ]);
            $this->oldImageDelete($category->image);

            $notifiaction = array(
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.all_category')->with($notifiaction);
        }else{
            Category::find($request->id)->update([
                'category_name' => $request->category_name,
            ]);
            $notifiaction = array(
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.all_category')->with($notifiaction);
        }
    }
    //End
    private function oldImageDelete($oldImage): void
    {
        $path = public_path($oldImage);
        unlink($path);
    }
    //End
    public function adminDeleteCategory($id){
        $category = Category::find($id);
        unlink($category->image);
        $category = Category::find($id)->delete();
        $notifiaction = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notifiaction);
    }
}
