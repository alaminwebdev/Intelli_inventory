<?php

namespace App\Services;

use App\Models\ProductInformation;

use App\Services\IService;
use Illuminate\Http\Request;

/**
 * Class ProductInformationService
 * @package App\Services
 */
class ProductInformationService implements IService
{

    public function getAll()
    {
        try {
            $data = ProductInformation::latest()->get();
            return $data;
        } catch (\Exception $e) {
            $d['error'] = 'Something wrong';
            return response()->json(["msg" => $e->getMessage()]);
        }
    }

    public function create(Request $request)
    {
        try {
            $data           = new ProductInformation();
            $data->name     = $request->name;
            $data->status   = $request->status ?? 0;
            $data->save();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
        $data = ProductInformation::find($id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        try {
            $data           = ProductInformation::find($id);
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
        $user = ProductInformation::find($id);
        $user->delete();
        return true;
    }
}
