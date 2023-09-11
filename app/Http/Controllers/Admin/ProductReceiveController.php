<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ProductInformationService;
use App\Services\ProductTypeService;
use App\Services\UnitService;
use App\Services\SupplierService;


class ProductReceiveController extends Controller
{
    private $productInformationService;
    private $productTypeService;
    private $unitService;
    private $supplierService;

    public function __construct(
        ProductInformationService $productInformationService,
        ProductTypeService $productTypeService,
        UnitService $unitService,
        SupplierService $supplierService

    ) {
        $this->productInformationService    = $productInformationService;
        $this->productTypeService           = $productTypeService;
        $this->unitService                  = $unitService;
        $this->supplierService              = $supplierService;
    }
    public function index()
    {
        $data['title']      = 'Product Receive Information List';
        $data['products']   = $this->productInformationService->getAll();
        return view('admin.product-management.product-receive.list', $data);
    }
    public function add()
    {
        $data['title']          = 'Add Product Receive Information';
        $data['product_types']  = $this->productTypeService->getProductTypeByStatus();
        $data['units']          = $this->unitService->getUnitByStatus();
        $data['suppliers']      = $this->supplierService->getSupplierByStatus();
        return view('admin.product-management.product-receive.add', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'code'          => 'required',
            'name'          => 'required',
            'product_type'  => 'required',
            'unit'          => 'required',
        ]);
        $this->productInformationService->create($request);
        return redirect()->route('admin.product.information.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title']          = 'Edit Product Receive Information';
        $data['editData']       = $this->productInformationService->getByID($id);
        $data['product_types']  = $this->productTypeService->getProductTypeByStatus();
        $data['units']          = $this->unitService->getUnitByStatus();
        return view('admin.system-setup.product-information.add', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code'          => 'required',
            'name'          => 'required',
            'product_type'  => 'required',
            'unit'          => 'required',
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
    public function getProductByType(Request $request)
    {
        dd($request->product_type_id);
    }
}
