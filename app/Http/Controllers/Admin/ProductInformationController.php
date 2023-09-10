<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ProductInformationService;

class ProductInformationController extends Controller
{
    private $productInformationService;

    public function __construct(ProductInformationService $productInformationService)
    {
        $this->productInformationService  = $productInformationService;
    }
    public function index(){
        $data['title'] = 'Product Information List';
        $data['products'] = $this->productInformationService->getAll();
        return view('admin.system-setup.product-information.list', $data);
    }
    public function add()
    {
        $data['title'] = 'Add Product';
        return view('admin.system-setup.product-information.add', $data);
    }
    public function store(Request $request)
    {
        dd($request->all());
        $request->validate([
            'name' => 'required',
        ]);
        $this->productInformationService->create($request);
        return redirect()->route('admin.product.information.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title'] = 'Edit Product';
        $data['editData'] = $this->productInformationService->getByID($id);
        return view('admin.system-setup.product-information.add', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->productInformationService->update($request, $id);
        return redirect()->route('admin.product.information.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request) {
        $deleted = $this->productInformationService->delete($request->id);
        if($deleted){
            return response()->json(['status'=>'success','message'=>'Successfully Deleted']);
        }else{
            return response()->json(['status'=>'error','message'=>'Sorry something wrong']);
        }
    }
}
