<?php

namespace App\Services;


use App\Models\EmployeeDesignation;

use App\Services\IService;
use Illuminate\Http\Request;

/**
 * Class DesignationService
 * @package App\Services
 */
class DesignationService implements IService
{

    public function getAll($status = null)
    {
        try {
            $query = EmployeeDesignation::latest();
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
            $data           = new EmployeeDesignation();
            $data->name     = $request->name;
            $data->sort     = $request->sort;
            $data->status   = $request->status ?? 0;
            $data->save();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
        $data = EmployeeDesignation::find($id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        try {
            $data           = EmployeeDesignation::find($id);
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
        $user = EmployeeDesignation::find($id);
        $user->delete();
        return true;
    }
}
