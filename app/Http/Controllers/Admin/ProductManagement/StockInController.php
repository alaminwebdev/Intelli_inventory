<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Models\ProductPoInfo;
use Illuminate\Http\Request;

use App\Services\ProductInformationService;
use App\Services\ProductTypeService;
use App\Services\SupplierService;
use App\Services\StockInService;
use Illuminate\Support\Facades\Validator;

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
        $data['title']          = 'Stock List';
        $data['stock_in_data']  = $this->stockInService->getAll();
        return view('admin.product-management.stock-in.list', $data);
    }

    public function selectProducts()
    {
        $data['title']                  = 'Select Product';
        return view('admin.product-management.stock-in.product-selection', $data);
    }

    public function checkPo(Request $request)
    {
        $poNo = $request->input('po_no');

        // Check if the PO number exists in your database
        $poExists =  ProductPoInfo::where('po_no', $poNo)->exists();

        if ($poExists) {
            // Retrieve the first po_date associated with the PO number
            $poDate             = ProductPoInfo::where('po_no', $poNo)->value('po_date');
            $formattedPoDate    = date('d-m-Y', strtotime($poDate));
            $poProducts         = $this->productInformationService->getPoProducts($poNo);
            $productsTable      = view('admin.product-management.stock-in.po-product-table')->with('products', $poProducts)->render();
            return response()->json(['exists' => true, 'po_date' =>$formattedPoDate, 'products' => $productsTable]);
        } else {
            // Return default product data
            $productTypes = $this->productInformationService->getProductTypeAndProducts();
            $defaultProductTable = view('admin.product-management.stock-in.default-product-table')->with('product_types', $productTypes)->render();
            return response()->json(['exists' => false, 'products' => $defaultProductTable]);
        }
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data['title']              = 'Add Stock';
            $selected_product_ids       = $request->input('selected_products', []);
            $data['selected_po_no']     = $request->input('po_no', '');
            $data['is_po_product']      = $request->input('is_po_product', '');
            $data['suppliers']          = $this->supplierService->getSupplierByStatus();
            $data['uniqueGRNNo']        = $this->stockInService->getUniqueGRNNo();
            if ($data['is_po_product'] == 1) {
                $data['selected_po_date']   = $request->input('old_po_date', '');
                $data['selected_products']  = $this->productInformationService->getPoProducts($data['selected_po_no'], $selected_product_ids);
                return view('admin.product-management.stock-in.add-po-products',$data);
            }else{
                $data['selected_po_date']   = $request->input('po_date', '');
                $data['selected_products']  = $this->productInformationService->getSpecificProducts($selected_product_ids);
                return view('admin.product-management.stock-in.add',$data);
            }
        }else{
            return redirect()->route('admin.stock.in.product.selection');
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grn_no'        => 'required',
            'entry_date'    => 'required',
            'challan_no'    => 'required',
            'supplier_id'   => 'required',
            'po_no'         => 'required',
            'po_qty'        => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $data = $this->stockInService->create($request);
        return response()->json($data);
    }
    public function updatePoProducts(Request $request)
    {
        // $data = $this->stockInService->updatePoProducts($request);
        // return response()->json($request);
    }
    public function edit($id)
    {
        $data['title']          = 'Update Stock';
        $data['editData']       = $this->stockInService->getByID($id);
        $data['suppliers']      = $this->supplierService->getSupplierByStatus();
        return view('admin.product-management.stock-in.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'grn_no'        => 'required',
            'entry_date'    => 'required',
            'challan_no'    => 'required',
            'supplier_id'   => 'required',
            'po_no'         => 'required',
            'po_qty'        => 'required',
        ]);

    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $data = $this->stockInService->update($request, $id);
        return response()->json($data);
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
