<?php

namespace App\Services\ProfileManagement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\IService;
use Illuminate\Support\Facades\Hash;
use Session;

/**
 * Class PasswordChangeService
 * @package App\Services
 */
class PasswordChangeService implements IService
{
    
    public function getAll()
	{

	}
    public function create(Request $request)
    { 
        $auth_id = Auth::user()->id;

    	// dd($auth_id);
    	if($request->new_password == $request->confirm_password)
    	{
    		$previous_password = Auth::user()->password;

            // dd(decrypt($previous_password));
            if(Hash::check($request->new_password, $previous_password))
            {
                session()->flash('msg', 'You Can not use old password as new Password!');
                return 2;
            }
            else{
                if(Hash::check($request->old_password,$previous_password))
                    {
                        $user = User::find($auth_id);
                        $password = Hash::make($request->new_password);
                        // dd($password);
                        $user->password = $password;
                        $user->update();
                        session()->flash('success', 'Password Change Successfully!');
                        return 1;

                    }
                    else
                    {
                        session()->flash('msg', 'Password does not match with previous password');
                        return 2;
                    }
            }
    	}
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
