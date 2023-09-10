<?php

namespace App\Services\ProfileManagement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\IService;

/**
 * Class ProfileChangeService
 * @package App\Services
 */
class ProfileChangeService implements IService
{
    
    public function getAll()
	{

	}
    public function create(Request $request)
    { 
        $auth_info = User::find(Auth::user()->id);
        $auth_info->name = $request->name;
        $auth_info->email = $request->email;
        $img = $request->file('image');
        if ($img) {
            @unlink(public_path('upload/user_images/'.$auth_info->image));
            $imgName = date('YmdHi').$img->getClientOriginalName();
            $img->move('public/upload/user_images/', $imgName);
            $auth_info['image'] = $imgName;
        }

        $auth_info->save();
    }  
	public function getByID($id)
	{ 

	}
    public function update(Request $request, $id)
    {

    }

    public function delete($id)
    {

    }

}
