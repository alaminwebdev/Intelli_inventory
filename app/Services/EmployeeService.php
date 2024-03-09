<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use App\Models\UserRole;
use App\Services\IService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class EmployeeService
 * @package App\Services
 */
class EmployeeService implements IService
{

    public function getAll()
    {
        try {
            $data = Employee::leftjoin('departments', 'departments.id', 'employees.department_id')
            ->leftjoin('sections', 'sections.id', 'employees.section_id')
            ->leftjoin('employee_designations', 'employee_designations.id', 'employees.designation_id')
            ->select(
                'employees.*',
                'departments.name as department',
                'sections.name as section',
                'employee_designations.name as designations',
            )
            ->latest()
            ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {
            $employee                   = new Employee();
            $employee->bp_no            = $request->bp_no;
            $employee->designation_id   = $request->designation_id;
            $employee->department_id    = $request->department_id;
            $employee->section_id       = $request->section_id;
            $employee->name             = $request->name;
            $employee->email            = $request->email;
            $employee->mobile_no        = $request->mobile_no;
            $employee->sort             = $request->sort;
            $employee->status           = $request->status ?? 0;
            $employee->save();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
        $data = Employee::find($id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        try {
            $employee                   = Employee::find($id);
            $employee->bp_no            = $request->bp_no;
            $employee->designation_id   = $request->designation_id;
            $employee->department_id    = $request->department_id;
            $employee->section_id       = $request->section_id;
            $employee->name             = $request->name;
            $employee->email            = $request->email;
            $employee->mobile_no        = $request->mobile_no;
            $employee->sort             = $request->sort;
            $employee->status           = $request->status;
            $employee->save();

            $user = User::where('employee_id', $request->id)->first();
            if ($user) {
                // Check if the email and mobile number already exist in the user database
                $existingUser = User::where('id', '!=', $user->id)
                    ->where(function ($query) use ($request) {
                        $query->where('email', $request->email)
                            ->orWhere('mobile_no', $request->mobile_no);
                    })
                    ->first();

                if (!$existingUser) {
                    $user->name           = $request->name;
                    $user->email          = $request->email;
                    $user->mobile_no      = $request->mobile_no;
                    $user->status         = $request->status;
                    $user->save();
                }
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $user = Employee::find($id);
        $user->delete();
        return true;
    }
}
