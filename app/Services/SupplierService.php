<?php

namespace App\Services;


use App\Models\Supplier;

use App\Services\IService;
use Illuminate\Http\Request;

/**
 * Class SupplierService
 * @package App\Services
 */
class SupplierService implements IService
{

    public function getAll()
    {
        try {
            $data = Supplier::latest()->get();
            return $data;
        } catch (\Exception $e) {
            $d['error'] = 'Something wrong';
            return response()->json(["msg" => $e->getMessage()]);
        }
    }
    public function getSupplierByStatus()
    {
        try {
            $data = Supplier::where('status', 1)->latest()->get();
            return $data;
        } catch (\Exception $e) {
            $d['error'] = 'Something wrong';
            return response()->json(["msg" => $e->getMessage()]);
        }
    }

    public function create(Request $request)
    {
        try {
            $data           = new Supplier();
            $data->name     = $request->name;
            $data->phone    = $request->phone;
            $data->email    = $request->email;
            $data->address  = $request->address;
            $data->status   = $request->status ?? 0;
            $data->save();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
        $data = Supplier::find($id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        try {
            $data           = Supplier::find($id);
            $data->name     = $request->name;
            $data->phone    = $request->phone;
            $data->email    = $request->email;
            $data->address  = $request->address;
            $data->status   = $request->status ?? 0;
            $data->save();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $user = Supplier::find($id);
        $user->delete();
        return true;
    }
}
