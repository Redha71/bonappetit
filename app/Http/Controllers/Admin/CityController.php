<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function adminAllCity()
    {
        $city = City::latest()->get();
        return view('admin.backend.city.all_city', compact('city'));
    }
    //End
    public function adminAddCitySubmit(Request $request)
    {
            City::create([
                'city_name' => $request->city_name,
                'city_slug' => strtolower(str_replace(' ','-',$request->city_name))
            ]);
            $notifiaction = array(
                'message' => 'City Saved Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notifiaction);
        
    }
    //End
}
