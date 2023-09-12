<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ProductInformationService;
use App\Services\ProductTypeService;
use App\Services\SupplierService;
use App\Services\StockInService;


class StockInController extends Controller
{
    private $productInformationService;
    private $productTypeService;
    private $supplierService;
    private $stockInService;

    public function __construct(
        ProductInformationService $productInformationService,
        ProductTypeService $productTypeService,
        SupplierService $supplierService,
        StockInService $stockInService

    ) {
        $this->productInformationService    = $productInformationService;
        $this->productTypeService           = $productTypeService;
        $this->supplierService              = $supplierService;
        $this->stockInService               = $stockInService;
    }
    public function index()
    {
        $data['title']          = 'Stock-In List';
        $data['stock_in_data']  = $this->stockInService->getAll();
        return view('admin.product-management.stock-in.list', $data);
    }
    public function add()
    {
        $data['title']          = 'Add Stock';
        $data['product_types']  = $this->productTypeService->getProductTypeByStatus();
        $data['suppliers']      = $this->supplierService->getSupplierByStatus();
        $data['uniqueGRNNo']    = $this->stockInService->getUniqueGRNNo();
        return view('admin.product-management.stock-in.add', $data);
    }
    public function store(Request $request)
    {
        // $request->validate([
        //     'code'          => 'required',
        //     'name'          => 'required',
        //     'product_type'  => 'required',
        //     'unit'          => 'required',
        // ]);
        $data = $this->stockInService->create($request);
        return response()->json($data);
    }
    public function edit($id)
    {
        // $data['title']          = 'Edit Stock';
        // $data['editData']       = $this->stockInService->getByID($id);
        // $data['product_types']  = $this->productTypeService->getProductTypeByStatus();
        // $data['suppliers']      = $this->supplierService->getSupplierByStatus();
        // return view('admin.product-management.product-receive.add', $data);
    }

    public function update(Request $request, $id)
    {
        // $this->productInformationService->update($request, $id);
        // return redirect()->route('admin.product.information.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request)
    {
        // $deleted = $this->productInformationService->delete($request->id);
        // if ($deleted) {
        //     return response()->json(['status' => 'success', 'message' => 'Successfully Deleted']);
        // } else {
        //     return response()->json(['status' => 'error', 'message' => 'Sorry something wrong']);
        // }
    }
}
