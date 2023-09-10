<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class DeleteController extends Controller
{
	// use SoftDeletes;
    public function deleteData()
    {
    	$id 	= request()->id;
    	$table 	= request()->table;
    	$data 	= DB::table($table)->where('id',$id)->update(['deleted_at'=>date('Y-m-d')]);
    	
    	if($data){
    		return response()->json(['status'=>true]);
    	}else{
    		return response()->json(['status'=>false]);
    	}
    }
}
