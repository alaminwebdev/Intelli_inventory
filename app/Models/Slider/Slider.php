<?php

namespace App\Models\Slider;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;
    Protected $fillable = ['text_on_banner','description','show_description','image','slider_master_id'];
    public function slider_master()
    {
        return $this->belongsTo(SliderMaster::class);
    }
}
