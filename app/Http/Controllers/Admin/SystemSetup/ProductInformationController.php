<?php

namespace App\Http\Controllers\Admin\SystemSetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ProductInformationService;
use App\Services\ProductTypeService;
use App\Services\UnitService;

class ProductInformationController extends Controller
{
    private $productInformationService;
    private $productTypeService;
    private $unitService;

    public function __construct(
        ProductInformationService $productInformationService,
        ProductTypeService $productTypeService,
        UnitService $unitService

    ) {
        $this->productInformationService    = $productInformationService;
        $this->productTypeService           = $productTypeService;
        $this->unitService                  = $unitService;
    }
    public function index()
    {
        $data['title']      = 'Product List';
        $data['products']   = $this->productInformationService->getAll();
        return view('admin.system-setup.product-information.list', $data);
    }
    public function add()
    {
        $data['title']          = 'Add Product';
        $data['product_types']  = $this->productTypeService->getAll(1);
        $data['units']          = $this->unitService->getAll(1);
        return view('admin.system-setup.product-information.add', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            // 'code'              => 'required',
            'name'              => 'required',
            'product_type_id'   => 'required',
            'unit_id'           => 'required',
        ]);
        $this->productInformationService->create($request);
        return redirect()->route('admin.product.information.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title']          = 'Update Product';
        $data['editData']       = $this->productInformationService->getByID($id);
        $data['product_types']  = $this->productTypeService->getAll(1);
        $data['units']          = $this->unitService->getAll(1);
        return view('admin.system-setup.product-information.add', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'code'              => 'required',
            'name'              => 'required',
            'product_type_id'   => 'required',
            'unit_id'           => 'required',
        ]);
        $this->productInformationService->update($request, $id);
        return redirect()->route('admin.product.information.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request)
    {
        $deleted = $this->productInformationService->delete($request->id);
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Successfully Deleted']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sorry something wrong']);
        }
    }
}
