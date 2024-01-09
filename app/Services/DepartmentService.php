<?php

namespace App\Services;

use App\Models\Department;

use App\Services\IService;
use Illuminate\Http\Request;

/**
 * Class DepartmentService
 * @package App\Services
 */
class DepartmentService implements IService
{

    public function getAll($status = null)
    {
        try {
            $query = Department::latest();
            if ($status) {
                $query->where('status', 1);
            }
            $data = $query->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {
            $data           = new Department();
            $data->name     = $request->name;
            $data->sort     = $request->sort;
            $data->status   = $request->status ?? 0;
            $data->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
        $data = Department::find($id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        try {
            $data           = Department::find($id);
            $data->name     = $request->name;
            $data->sort     = $request->sort;
            $data->status   = $request->status;
            $data->save();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $user = Department::find($id);
        $user->delete();
        return true;
    }
}
