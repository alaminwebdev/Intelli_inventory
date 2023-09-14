<?php

namespace App\Services;


use App\Models\Unit;

use App\Services\IService;
use Illuminate\Http\Request;

/**
 * Class UnitService
 * @package App\Services
 */
class UnitService implements IService
{

    public function getAll($status = null)
    {
        try {
            $query = Unit::latest();
            if ($status) {
                $query->where('status', 1);
            }
            $data =$query->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {
            $data           = new Unit();
            $data->name     = $request->name;
            $data->status   = $request->status ?? 0;
            $data->save();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
        $data = Unit::find($id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        try {
            $data           = Unit::find($id);
            $data->name     = $request->name;
            $data->status   = $request->status;
            $data->save();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $user = Unit::find($id);
        $user->delete();
        return true;
    }
}
