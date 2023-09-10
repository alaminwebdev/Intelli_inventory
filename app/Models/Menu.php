<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    public function child(){
    	return $this->hasMany(Menu::class,'parent','id');
    }

    public function permission(){
    	return $this->hasMany(MenuPermission::class);
    }

    public function module(){
    	return $this->belongsTo(Module::class);
    }
}
