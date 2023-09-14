<?php

namespace App\Services;


use App\Models\DepartmentRequisition;


use App\Services\IService;
use Illuminate\Http\Request;

/**
 * Class DepartmentRequisitionService
 * @package App\Services
 */
class DepartmentRequisitionService implements IService
{

    public function getAll()
    {
        try {
            $data = DepartmentRequisition::latest()->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getUniqueRequisitionNo()
    {
        do {
            $requisition_no = rand(10000, 99999);
        } while (DepartmentRequisition::where('requisition_no', $requisition_no)->exists());

        return $requisition_no;
    }

    public function create(Request $request)
    {
        // try {
        //     $data                   = new Section();
        //     $data->name             = $request->name;
        //     $data->department_id    = $request->department_id;
        //     $data->sort             = $request->sort;
        //     $data->status           = $request->status ?? 0;
        //     $data->save();
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }

    public function getByID($id)
    {
        $data = DepartmentRequisition::find($id);
        return $data;
    }

    public function update(Request $request, $id)
    {
        // try {
        //     $data                 = Section::find($id);
        //     $data->name           = $request->name;
        //     $data->department_id  = $request->department_id;
        //     $data->sort           = $request->sort;
        //     $data->status         = $request->status;
        //     $data->save();
        //     return true;
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }

    public function delete($id)
    {
        // $user = Section::find($id);
        // $user->delete();
        // return true;
    }
}
