<?php

namespace App\Services;


use App\Models\ProductType;

use App\Services\IService;
use Illuminate\Http\Request;

/**
 * Class ProductTypeService
 * @package App\Services
 */
class ProductTypeService implements IService
{

    public function getAll($status = null)
    {
        try {
            $query = ProductType::latest();
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
            $data           = new ProductType();
            $data->name     = $request->name;
            $data->status   = $request->status ?? 0;
            $data->save();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
        $data = ProductType::find($id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        try {
            $data           = ProductType::find($id);
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
        $user = ProductType::find($id);
        $user->delete();
        return true;
    }
}
