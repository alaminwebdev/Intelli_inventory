<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\EmployeeService;

class DashboardController extends Controller
{
    private $employeeService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->middleware('auth:admin');
        $this->employeeService = $employeeService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Initialize the dashboard variable
        $dashboard = '';

        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $userRoleIds = UserRole::where('user_id', $user->id)->pluck('role_id');

            // Check the user's role IDs and set the appropriate dashboard
            foreach ($userRoleIds as $roleId) {
                switch ($roleId) {
                    // Role Id 5 = Section Requisition Maker
                    case 5:
                        $dashboard = 'admin.dashboard.section-dashboard';
                        break;
                    case 2:
                        $dashboard = 'admin.dashboard.dashboard';
                        break;
                    case 3:
                        $dashboard = 'admin.dashboard.dashboard';
                        break;
                    default:
                        $dashboard = 'admin.dashboard.dashboard';
                        break;
                }
            }
        } else {
            $dashboard = 'admin.dashboard.dashboard';
        }

        return view($dashboard);
    }
}
