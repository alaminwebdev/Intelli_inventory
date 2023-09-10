<?php

namespace App\Http\Controllers\Backend\ProfileManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserLog;
use Session;
use Auth;
use App\Services\ProfileManagement\PasswordChangeService; 

class PasswordChangeController extends Controller
{
    private $passwordChangeService;

    public function __construct(PasswordChangeService $passwordChangeService)
    {
        $this->passwordChangeService = $passwordChangeService;
    }
    //
    public function changePassword()
    {
    	return view('backend.profile_management.change_password.change-password');
    }

    public function storePassword(Request $request)
    {
    	$request->validate([
            'old_password' => 'required',
    		'new_password' => 'required|min:8',
    		'confirm_password' => 'required|same:new_password',
    	]);

        $returnValue = $this->passwordChangeService->create($request);
        
        if($returnValue == 1)
        {
            return redirect()->route('profile-management.change.password');
        }
        elseif($returnValue == 2)
        {
            return redirect()->back();
        }

    	// return view('backend.profile_management.change_password.change-password');
    }

}
