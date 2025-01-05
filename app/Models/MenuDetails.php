<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuDetails extends Model
{
    protected $guarded = [];

    public function menu(){
        return $this->belongsTo(Menu::class,'menu_id','id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id','id');
    }
}

