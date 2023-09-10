<?php

namespace App\Http\Controllers\Backend\ProfileManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserLog;
use Session;
use Auth;
use App\Services\ProfileManagement\ProfileChangeService;

class ProfileChangeController extends Controller
{
    private $profileChangeService;

    public function __construct(ProfileChangeService $profileChangeService)
    {
        $this->profileChangeService = $profileChangeService;
    }

    public function changeProfile()
    {
        $data['auth_info'] = Auth::user();
        return view('backend.profile_management.change_profile.profile_change',$data);
    }

    public function storeProfile(Request $request)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'image' => 'mimes:png,jpg,jpeg'
        ]);

        $this->profileChangeService->create($request);
        
        return redirect()->route('profile-management.change.profile')->with('success','Profile updated Successfully');
    }

}
