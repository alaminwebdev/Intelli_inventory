<?php

namespace App\Http\Controllers\Admin\SystemSetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\UnitService;

class UnitController extends Controller
{
    private $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService  = $unitService;
    }
    public function index(){
        $data['title'] = 'Unit List';
        $data['units'] = $this->unitService->getAll();
        return view('admin.system-setup.unit.list', $data);
    }
    public function add()
    {
        $data['title'] = 'Add Unit';
        return view('admin.system-setup.unit.add', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->unitService->create($request);
        return redirect()->route('admin.unit.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title'] = 'Update Unit';
        $data['editData'] = $this->unitService->getByID($id);
        return view('admin.system-setup.unit.add', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->unitService->update($request, $id);
        return redirect()->route('admin.unit.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request) {
        $deleted = $this->unitService->delete($request->id);
        if($deleted){
            return response()->json(['status'=>'success','message'=>'Successfully Deleted']);
        }else{
            return response()->json(['status'=>'error','message'=>'Sorry something wrong']);
        }
    }

}
