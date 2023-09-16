<?php

namespace App\Services;

use App\Models\Section;

use App\Services\IService;
use Illuminate\Http\Request;

/**
 * Class SectionService
 * @package App\Services
 */
class SectionService implements IService
{

    public function getAll()
    {
        try {
            $data = Section::join('departments', 'departments.id', 'sections.department_id')
                ->select(
                    'sections.*',
                    'departments.name as department_name'
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
            $data                   = new Section();
            $data->name             = $request->name;
            $data->department_id    = $request->department_id;
            $data->sort             = $request->sort;
            $data->status           = $request->status ?? 0;
            $data->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
        $data = Section::find($id);
        return $data;
    }
    public function getSectionsByDepartment($id)
    {
        $data = Section::where('department_id', $id)->where('status',1)->get();
        return $data;
    }
    public function update(Request $request, $id)
    {
        try {
            $data                 = Section::find($id);
            $data->name           = $request->name;
            $data->department_id  = $request->department_id;
            $data->sort           = $request->sort;
            $data->status         = $request->status;
            $data->save();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $user = Section::find($id);
        $user->delete();
        return true;
    }
}
