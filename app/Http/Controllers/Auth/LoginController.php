<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectAdminTo = RouteServiceProvider::ADMIN_DASHBOARD;
    // protected $redirectMemberTo = RouteServiceProvider::member_DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:member')->except('logout');
    }

    public function showLoginForm()
    {
        $data = ['url' => route(getGuard().'.login'), 'title'=>(getGuard() == 'admin')?'Admin':'Member'];
        return view('auth.login', $data);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'user'   => 'required',
            'password' => 'required'
        ]);

        if(strlen($request->user) == '11'){
            $user = 'mobile_no';
            $request->merge(['mobile_no' => $request->user]);
        }else{
            $user = 'email';
            $request->merge(['email' => $request->user]);
        }

        if (Auth::attempt($request->only([$user,'password']), $request->get('remember'))){
            return redirect()->route(getGuard().'.dashboard');
        }

        return redirect()->back()->with('login_error','Your user information or password is incorrect');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route(getGuard().'.login');
    }

}
