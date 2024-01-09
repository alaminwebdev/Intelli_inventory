<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','description','phone_status','mail_status','status','created_by'];
	public function getRouteKeyName()
	{
		return "name";
	}

	public function otp_role_list(){
		return $this->hasMany(OtpRole::class,'role_id','id');
	}
}
