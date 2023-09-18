<?php

namespace App\Services;

use App\Models\StockIn;
use App\Models\StockInDetail;
use App\Services\IService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class StockInService
 * @package App\Services
 */
class StockInService implements IService {

    public function getAll() {
        try {
            $data = StockIn::leftjoin('suppliers', 'suppliers.id', 'stock_ins.supplier_id')
                ->select(
                    'stock_ins.*',
                    'suppliers.name as supplier',
                )
                ->latest()
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUniqueGRNNo() {
        do {
            $grnNo = rand(10000, 99999);
        } while (StockIn::where('grn_no', $grnNo)->exists());

        return $grnNo;
    }

    public function create(Request $request) {

        DB::beginTransaction();
        try {
            $data = $request->input('data'); // Access the 'data' key in the payload

            $stockInData              = new StockIn();
            $stockInData->user_id     = Auth::id();
            $stockInData->grn_no      = $data['grn_no'];
            $stockInData->entry_date  = $data['entry_date'];
            $stockInData->challan_no  = $data['challan_no'];
            $stockInData->supplier_id = $data['supplier_id'];
            $stockInData->status      = 0; // You may need to adjust how 'status' is passed
            $stockInData->created_by  = Auth::id();

            if ($stockInData->save()) {
                $stockInDetails = $data['stockInDetail'] ?? []; // Access the 'stockInDetail' array

                foreach ($stockInDetails as $key => $value) {
                    $stockInDetailData                         = new StockInDetail();
                    $stockInDetailData->stock_in_id            = $stockInData->id;
                    $stockInDetailData->product_information_id = $value['productInformationId'];
                    $stockInDetailData->po_no                  = $value['poNo'];
                    $stockInDetailData->po_date                = $value['poDate'];
                    $stockInDetailData->mfg_date               = $value['mfgDate'];
                    $stockInDetailData->expire_date            = $value['expireDate'];
                    $stockInDetailData->invoice_qty            = $value['invoiceQty'];
                    $stockInDetailData->receive_qty            = $value['receiveQty'];
                    $stockInDetailData->reject_qty             = $value['rejectQty'];
                    $stockInDetailData->available_qty          = $value['receiveQty'];
                    $stockInDetailData->dispatch_qty           = 0;
                    $stockInDetailData->remarks                = $value['remarks'];
                    $stockInDetailData->save();
                }
            }
            DB::commit();
            return response()->json(['success' => 'Stock Information Inserted']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getByID($id) {
        $data = StockIn::find($id);
        return $data;
    }
    public function update(Request $request, $id) {
        // try {
        //     $data                   = ProductInformation::find($id);
        //     $data->code             = $request->code;
        //     $data->name             = $request->name;
        //     $data->product_type_id  = $request->product_type_id;
        //     $data->unit_id          = $request->unit_id;
        //     $data->status           = $request->status ?? 0;
        //     $data->save();
        //     return true;
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }

    public function delete($id) {
        // $user = ProductInformation::find($id);
        // $user->delete();
        // return true;
    }

}
