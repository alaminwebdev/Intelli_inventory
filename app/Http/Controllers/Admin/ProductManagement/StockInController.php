<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Models\ProductPoInfo;
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
        $data['title']          = 'স্টক তালিকা';
        $data['stock_in_data']  = $this->stockInService->getAll();
        return view('admin.product-management.stock-in.list', $data);
    }

    public function selectProducts()
    {
        $data['title']                  = 'পন্য বাছাই করুন';
        // $data['product_types']          = $this->productInformationService->getProductTypeAndProducts();
        return view('admin.product-management.stock-in.product-selection', $data);
    }
    public function processSelectionProducts(Request $request)
    {
        // Retrieve the selected product IDs from the request
        $selectedProductIds = $request->input('selected_products');
        $po_no              = $request->input('po_no');
        $po_date            = $request->input('po_date');
        // Redirect to the "add" step for section requisition with selected product IDs
        return redirect()->route('admin.stock.in.add', ['sp' => $selectedProductIds, 'po_no' => $po_no, 'po_date' => $po_date]);
    }

    public function checkPo(Request $request)
    {
        $poNo = $request->input('po_no');

        // Check if the PO number exists in your database
        $poExists =  ProductPoInfo::where('po_no', $poNo)->exists();

        if ($poExists) {
            // Return product data based on the PO number
            return response()->json(['exists' => true, 'products' => $poNo]);
        } else {
            // Return default product data
            $productTypes = $this->productInformationService->getProductTypeAndProducts();
            $defaultProductTable = view('admin.product-management.stock-in.default-product-table')->with('product_types', $productTypes)->render();
            return response()->json(['exists' => false, 'products' => $defaultProductTable]);
        }
    }

    public function add(Request $request)
    {
        dd($request->all());
        // Retrieve the selected product IDs from the query parameters
        $data['title']              = 'স্টক যুক্ত করুন';
        $selected_product_ids       = $request->input('sp', []);
        $data['selected_po_no']     = $request->input('po_no', '');
        $data['selected_po_date']   = $request->input('po_date', '');
        $data['selected_products']  = $this->productInformationService->getSpecificProducts($selected_product_ids);
        // $data['product_types']      = $this->productTypeService->getAll(1);
        $data['suppliers']          = $this->supplierService->getSupplierByStatus();
        $data['uniqueGRNNo']        = $this->stockInService->getUniqueGRNNo();
        return view('admin.product-management.stock-in.add', $data);
    }
    /*
    */
    public function store(Request $request)
    {
        // $request->validate([
        //     'code'          => 'required',
        //     'name'          => 'required',
        //     'product_type'  => 'required',
        //     'unit'          => 'required',
        // ]);
        // dd($request->all());
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
    public function active($id)
    {
        $this->stockInService->active($id);
        return redirect()->route('admin.stock.in.list')->with('success', 'Successfully Approved!');
    }
}
