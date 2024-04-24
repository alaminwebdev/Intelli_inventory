<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\SectionService;
use App\Services\DepartmentService;

class SectionController extends Controller
{
    private $departmentService;
    private $sectionService;

    public function __construct(
        DepartmentService $departmentService,
        SectionService $sectionService
    ) {
        $this->departmentService    = $departmentService;
        $this->sectionService       = $sectionService;
    }
    public function index()
    {
        $data['title']      = 'Section List';
        $data['sections']   = $this->sectionService->getAll();
        return view('admin.employee-management.section.list', $data);
    }
    public function add()
    {
        $data['title']          = 'Add Section';
        $data['departments']    = $this->departmentService->getAll();
        return view('admin.employee-management.section.add', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'department_id' => 'required',
        ]);
        $this->sectionService->create($request);
        return redirect()->route('admin.section.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title']          = 'Update Section';
        $data['editData']       = $this->sectionService->getByID($id);
        $data['departments']    = $this->departmentService->getAll();
        return view('admin.employee-management.section.add', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'department_id' => 'required',
        ]);
        $this->sectionService->update($request, $id);
        return redirect()->route('admin.section.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request)
    {
        $deleted = $this->sectionService->delete($request->id);
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Successfully Deleted']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sorry something wrong']);
        }
    }
}
