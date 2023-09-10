<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuRoute extends Model
{
    public function menu(){
    	return $this->belongsTo(Menu::class,'menu_id','id');
    }
}
