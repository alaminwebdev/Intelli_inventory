<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ProductTypeService;
use App\Services\SectionRequisitionService;

class SectionRequisitionController extends Controller
{
    private $sectionRequisitionService;
    private $productTypeService;

    public function __construct(
        SectionRequisitionService $sectionRequisitionService,
        ProductTypeService $productTypeService
    ) {
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->productTypeService           = $productTypeService;
    }
    public function index()
    {
        $data['title']      = 'Section Requisition List';
        $data['sections']   = $this->sectionRequisitionService->getAll();
        return view('admin.requisition-management.section-requisition.list', $data);
    }
    public function add()
    {
        $data['title']                  = 'Add Section Requisition';
        $data['product_types']          = $this->productTypeService->getAll(1);
        $data['uniqueRequisitionNo']    = $this->sectionRequisitionService->getUniqueRequisitionNo();
        return view('admin.requisition-management.section-requisition.add', $data);
    }
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        // ]);
        $this->sectionRequisitionService->create($request);
        return redirect()->route('admin.section.requisition.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title']          = 'Edit Section Requisition';
        $data['editData']       = $this->sectionRequisitionService->getByID($id);
        return view('admin.requisition-management.section-requisition.add', $data);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required',
        // ]);
        $this->sectionRequisitionService->update($request, $id);
        return redirect()->route('admin.section.requisition.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request)
    {
        $deleted = $this->sectionRequisitionService->delete($request->id);
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Successfully Deleted']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sorry something wrong']);
        }
    }
}
