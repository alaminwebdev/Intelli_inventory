<?php

namespace App\Http\Controllers\Admin\SystemSetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ProductTypeService;

class ProductTypeController extends Controller
{
    private $productTypeService;

    public function __construct(ProductTypeService $productTypeService)
    {
        $this->productTypeService  = $productTypeService;
    }
    public function index(){
        $data['title'] = 'Product Type List';
        $data['product_types'] = $this->productTypeService->getAll();
        return view('admin.system-setup.product-type.list', $data);
    }
    public function add()
    {
        $data['title'] = 'Add Product Type';
        return view('admin.system-setup.product-type.add', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->productTypeService->create($request);
        return redirect()->route('admin.product.type.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title'] = 'Update Product Type';
        $data['editData'] = $this->productTypeService->getByID($id);
        return view('admin.system-setup.product-type.add', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->productTypeService->update($request, $id);
        return redirect()->route('admin.product.type.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request) {
        $deleted = $this->productTypeService->delete($request->id);
        if($deleted){
            return response()->json(['status'=>'success','message'=>'Successfully Deleted']);
        }else{
            return response()->json(['status'=>'error','message'=>'Sorry something wrong']);
        }
    }
}
