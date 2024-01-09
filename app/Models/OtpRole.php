<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpRole extends Model
{
    use HasFactory;

    public function otp(){
        return $this->belongsTo(Otp::class,'otp_id','id');
    }
}
