<?php

namespace App\Http\Controllers\Admin\SystemSetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\SupplierService;

class SupplierController extends Controller
{
    private $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService  = $supplierService;
    }
    public function index(){
        $data['title']      = 'Supplier List';
        $data['suppliers']  = $this->supplierService->getAll();
        return view('admin.system-setup.supplier.list', $data);
    }
    public function add()
    {
        $data['title'] = 'Add Supplier';
        return view('admin.system-setup.supplier.add', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->supplierService->create($request);
        return redirect()->route('admin.supplier.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title'] = 'Update Supplier';
        $data['editData'] = $this->supplierService->getByID($id);
        return view('admin.system-setup.supplier.add', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->supplierService->update($request, $id);
        return redirect()->route('admin.supplier.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request) {
        $deleted = $this->supplierService->delete($request->id);
        if($deleted){
            return response()->json(['status'=>'success','message'=>'Successfully Deleted']);
        }else{
            return response()->json(['status'=>'error','message'=>'Sorry something wrong']);
        }
    }
}
