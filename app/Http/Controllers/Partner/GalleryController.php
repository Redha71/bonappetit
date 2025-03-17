<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GalleryController extends Controller
{
    public function galleryAll()
    {
        $id= Auth::guard('partner')->id();
        $gallery = Gallery::where('partner_id',$id)->orderBy('id','desc')->get();
        return view('partner.backend.gallery.all_gallery', compact('gallery'));
    }
    //End
    public function addGallery()
    {
        return view('partner.backend.gallery.add_gallery');
    }
    //End
    public function storeGallary(Request $request){

        if ($request->file('image')) {
            $images = $request->file('image');
            foreach ($images as $value) {
                $manager = new ImageManager(new Driver());
                $name_image = hexdec(uniqid()) . '.' . $value->getClientOriginalExtension();
                $img = $manager->read($value);
                $img->resize(300, 300)->save(public_path('image/gallary/' . $name_image));
                $save_path = 'image/gallary/' . $name_image;
                Gallery::create([
                    'image' => $save_path,
                    'partner_id'=> Auth::guard('partner')->id()
                ]);
               
            }
            $notifiaction = array(
                'message' => 'Images Saved Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('gallery.all')->with($notifiaction);
        }

    }
    //End
    public function editGallary($id){
        $gallary = Gallery::find($id);
        return view('partner.backend.gallery.edit_gallery', compact('gallary'));
    }
    public function gallaryUpdate(Request $request){
        $gallary = Gallery::find($request->id);
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_image = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('image/gallary/' . $name_image));
            $save_path = 'image/gallary/' . $name_image;
            Gallery::find($request->id)->update([
                'image' => $save_path
            ]);
            $this->oldImageDelete($gallary->image);

            $notifiaction = array(
                'message' => 'Gallary Image Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('gallery.all')->with($notifiaction);
        }else{
            
            $notifiaction = array(
                'message' => 'No Image Selected',
                'alert-type' => 'warning'
            );
            return redirect()->route('gallery.all')->with($notifiaction);
        }
    }
    private function oldImageDelete($oldImage): void
    {
        $path = public_path($oldImage);
        unlink($path);
    }
    //End
    public function deleteGallary($id){
        $gallary = Gallery::find($id);
        unlink($gallary->image);
        $gallary = Gallery::find($id)->delete();
        $notifiaction = array(
            'message' => 'Gallary Image Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notifiaction);
    }
}
