<?php

namespace App\Models;

use App\Http\Controllers\Backend\Homepage\GalleryCategoryController;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    Protected $fillable = ['gallery_category_id','title','image'];

    public function categories()
    {
        return $this->belongsTo(GalleryCategory::class,'gallery_category_id','id');
    }
}

