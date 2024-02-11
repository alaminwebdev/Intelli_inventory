<?php

namespace App\Services;

use App\Models\ProductPoInfo;
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
class StockInService implements IService
{

    public function getAll()
    {
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

    public function getUniqueGRNNo()
    {
        do {
            $grnNo = rand(10000, 99999);
        } while (StockIn::where('grn_no', $grnNo)->exists());

        return $grnNo;
    }

    public function create(Request $request)
    {

        DB::beginTransaction();
        try {

            $data = $request->all(); // Access all data from the request

            // Create a new StockIn record
            $stockInData          = new StockIn();
            $stockInData->user_id = Auth::id();
            $stockInData->grn_no  = $data['grn_no'];

            $entryDate               = date('Y-m-d', strtotime($data['entry_date']));
            $stockInData->entry_date = $entryDate;

            $stockInData->challan_no  = $data['challan_no'];
            $stockInData->po_no       = $data['po_no'];
            $stockInData->supplier_id = $data['supplier_id'];
            $stockInData->status      = 0; // You may need to adjust how 'status' is passed
            $stockInData->created_by  = Auth::id();

            if ($stockInData->save()) {
                // Access the nested arrays within the 'data' key
                $po_qty      = $data['po_qty'];
                $receive_qty = $data['receive_qty'];
                $reject_qty  = $data['reject_qty'];
                $mfg_date    = $data['mfg_date'];
                $expire_date = $data['expire_date'];
                $remarks     = $data['remarks'];

                foreach ($po_qty as $productId => $poQty) {
                    $stockInDetailData                         = new StockInDetail();
                    $stockInDetailData->stock_in_id            = $stockInData->id;
                    $stockInDetailData->product_information_id = $productId;
                    $stockInDetailData->po_no                  = $data['po_no'];

                    $poDate                              = date('Y-m-d', strtotime($data['po_date']));
                    $mfgDate                             = date('Y-m-d', strtotime($mfg_date[$productId]));
                    $expireDate                          = date('Y-m-d', strtotime($expire_date[$productId]));
                    $stockInDetailData->po_date          = $poDate;
                    $stockInDetailData->mfg_date         = $mfgDate;
                    $stockInDetailData->expire_date      = $expireDate;
                    $stockInDetailData->po_qty           = $poQty; // Assuming it corresponds to 'po_qty'
                    $stockInDetailData->receive_qty      = $receive_qty[$productId];
                    $stockInDetailData->reject_qty       = $reject_qty[$productId];
                    $stockInDetailData->available_qty    = $receive_qty[$productId];
                    $stockInDetailData->dispatch_qty     = 0;
                    $stockInDetailData->prev_receive_qty = isset($data['prev_receive_qty'][$productId]) ? $data['prev_receive_qty'][$productId] : null;
                    $stockInDetailData->remarks          = $remarks[$productId];
                    $stockInDetailData->save();

                    if ($stockInDetailData->save()) {

                        $productPoInfo                         = new ProductPoInfo();
                        $productPoInfo->po_no                  = $data['po_no'];
                        $productPoInfo->po_date                = $poDate;
                        $productPoInfo->stock_in_detail_id     = $stockInDetailData->id;
                        $productPoInfo->product_information_id = $productId;
                        $productPoInfo->reject_qty             = $reject_qty[$productId];
                        $productPoInfo->save();
                    }
                }
            }
            DB::commit();
            return response()->json(['success' => 'Stock Information Inserted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function updatePoProducts(Request $request)
    {

        DB::beginTransaction();
        try {

            $data = $request->all(); // Access all data from the request

            // Access the nested arrays within the 'data' key
            $stock_in_id = $data['stock_in_id'];
            $po_no       = $data['po_no'];
            $po_qty      = $data['po_qty'];
            $receive_qty = $data['receive_qty'];
            $reject_qty  = $data['reject_qty'];
            $mfg_date    = $data['mfg_date'];
            $expire_date = $data['expire_date'];
            $remarks     = $data['remarks'];

            foreach ($po_qty as $productId => $poQty) {

                $stockInDetailData = StockInDetail::where('stock_in_id', $stock_in_id)
                    ->where('product_information_id', $productId)
                    ->where('po_no', $po_no)
                    ->firstOrFail();

                // Check and update mfg_date if it's not null
                if (!is_null($mfg_date[$productId])) {
                    $stockInDetailData->mfg_date = date('Y-m-d', strtotime($mfg_date[$productId]));
                }

                // Check and update expire_date if it's not null
                if (!is_null($expire_date[$productId])) {
                    $stockInDetailData->expire_date = date('Y-m-d', strtotime($expire_date[$productId]));
                }

                $stockInDetailData->receive_qty   = $stockInDetailData->receive_qty + $receive_qty[$productId];
                $stockInDetailData->reject_qty    = $reject_qty[$productId];
                $stockInDetailData->available_qty = $stockInDetailData->available_qty + $receive_qty[$productId];
                $stockInDetailData->dispatch_qty  = 0;
                $stockInDetailData->remarks       = $remarks[$productId];
                $stockInDetailData->save();

                $productPoInfo = ProductPoInfo::where('stock_in_id', $stock_in_id)
                    ->where('product_information_id', $productId)
                    ->where('po_no', $po_no)
                    ->firstOrFail();

                $productPoInfo->reject_qty = $reject_qty[$productId];
                $productPoInfo->save();
            }
            DB::commit();
            return response()->json(['success' => 'Stock Information Inserted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getByID($id)
    {
        $data = StockIn::with('stockDetail')->find($id);
        return $data;
    }
    public function getStockDetails($id)
    {
        $data = StockInDetail::join('product_information', 'product_information.id', 'stock_in_details.product_information_id')
            ->where('stock_in_id', $id)
            ->select(
                'stock_in_details.po_qty as po_qty',
                'stock_in_details.prev_receive_qty as prev_receive_qty',
                'stock_in_details.receive_qty as receive_qty',
                'stock_in_details.reject_qty as reject_qty',
                'product_information.name as product'
            )
            ->get();
        return $data;
    }

    public function getMostStockProducts($request = null, $take = null, $days = null)
    {

        // Initialize an empty array to store the formatted data
        $formattedData = [];

        $mostStockInProducts = StockInDetail::join('product_information', 'product_information.id', 'stock_in_details.product_information_id')
            ->leftjoin('units', 'units.id', 'product_information.unit_id')
            ->when($request, function ($q, $request) {
                if (($request['date_from'] != null || $request['date_to'] != null)) {
                    $fromDate = date('Y-m-d', strtotime($request['date_from']));
                    $toDate   = date('Y-m-d', strtotime($request['date_to']));
                    $q->whereDate('stock_in_details.updated_at', '>=', $fromDate);
                    $q->whereDate('stock_in_details.updated_at', '<=', $toDate);
                } else {
                    $today_date = date('Y-m-d');
                    $q->whereDate('stock_in_details.updated_at', $today_date);
                }
            })
            ->when($days, function ($q, $days) {
                $days_ago = now()->subDays($days);
                $q->whereDate('stock_in_details.updated_at', '>=', $days_ago);
            })
            ->select(
                'product_information_id',
                'product_information.name as product',
                'units.name as unit',
                DB::raw('SUM(available_qty) as total_available_qty')
            )
            ->groupBy('stock_in_details.product_information_id', 'product_information.name', 'units.name')
            ->orderByDesc('total_available_qty')
            ->when($take, function ($q, $take) {
                $q->take($take);
            })
            ->get();

        // Modify the product names to keep only the unique first word and append an index when needed
        $uniqueProducts = [];

        // Iterate through the retrieved data and format it
        foreach ($mostStockInProducts as $product) {
            // $formattedData[] = [
            //     'product'   => $product->product . ' (' . $product->unit . ')',
            //     'quantity'  => (int) $product->total_available_qty,
            // ];

            $firstWord = strtok($product->product, ' ');

            // $formattedData[] = [
            //     'product'   => $product->product . ' (' . $product->unit . ')',
            //     'quantity'  => (int) $product->total_distribute_qty,
            // ];
            if (!isset($uniqueProducts[$firstWord])) {
                $uniqueProducts[$firstWord] = [
                    'product_short' => $firstWord,
                    'product'       => $product->product . ' (' . $product->unit . ')',
                    'quantity'      => (int) $product->total_available_qty,
                ];
            } else {

                // If the first word already exists, append an index to the first word
                $index = 1;
                while (isset($uniqueProducts[$firstWord . '_' . $index])) {
                    $index++;
                }

                $uniqueProducts[$firstWord . '_' . $index] = [
                    'product_short' => $firstWord . '_' . $index,
                    'product'       => $product->product . ' (' . $product->unit . ')',
                    'quantity'      => (int) $product->total_available_qty,
                ];
            }
        }
        // Convert the uniqueProducts array back to an array of values
        $formattedData = array_values($uniqueProducts);
        // Return the formatted data
        return $formattedData;
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Access all data from the request
            $data = $request->all();
            // Update a new StockIn record
            $stockInData          = StockIn::find($id);
            $stockInData->user_id = Auth::id();
            $stockInData->grn_no  = $data['grn_no'];

            $entryDate               = date('Y-m-d', strtotime($data['entry_date']));
            $stockInData->entry_date = $entryDate;

            $stockInData->challan_no  = $data['challan_no'];
            $stockInData->po_no       = $data['po_no'];
            $stockInData->supplier_id = $data['supplier_id'];
            // $stockInData->status      = 1;
            $stockInData->created_by  = Auth::id();

            if ($stockInData->save()) {
                // Access the nested arrays within the 'data' key
                $po_qty      = $data['po_qty'];
                $receive_qty = $data['receive_qty'];
                $reject_qty  = $data['reject_qty'];
                $mfg_date    = $data['mfg_date'];
                $expire_date = $data['expire_date'];
                $remarks     = $data['remarks'];

                $stock_in_details     = $data['stock_in_detail_id'];

                foreach ($po_qty as $productId => $poQty) {
                    $stockInDetailData                         = StockInDetail::find($stock_in_details[$productId]);
                    $stockInDetailData->stock_in_id            = $stockInData->id;
                    $stockInDetailData->product_information_id = $productId;
                    $stockInDetailData->po_no                  = $data['po_no'];

                    $poDate                              = date('Y-m-d', strtotime($data['po_date']));
                    $mfgDate                             = date('Y-m-d', strtotime($mfg_date[$productId]));
                    $expireDate                          = date('Y-m-d', strtotime($expire_date[$productId]));
                    $stockInDetailData->po_date          = $poDate;
                    $stockInDetailData->mfg_date         = $mfgDate;
                    $stockInDetailData->expire_date      = $expireDate;
                    $stockInDetailData->po_qty           = $poQty; // Assuming it corresponds to 'po_qty'
                    $stockInDetailData->receive_qty      = $receive_qty[$productId];
                    $stockInDetailData->reject_qty       = $reject_qty[$productId];
                    $stockInDetailData->available_qty    = $receive_qty[$productId];
                    $stockInDetailData->dispatch_qty     = 0;
                    // $stockInDetailData->prev_receive_qty = isset($data['prev_receive_qty'][$productId]) ? $data['prev_receive_qty'][$productId] : null;
                    $stockInDetailData->remarks          = $remarks[$productId];
                    $stockInDetailData->save();

                    if ($stockInDetailData->save()) {

                        $productPoInfo                         = ProductPoInfo::where('stock_in_detail_id', $stockInDetailData->id)->where('product_information_id', $productId)->first();
                        $productPoInfo->po_no                  = $data['po_no'];
                        $productPoInfo->po_date                = $poDate;
                        $productPoInfo->reject_qty             = $reject_qty[$productId];
                        $productPoInfo->save();
                    }
                }
            }
            DB::commit();
            return response()->json(['success' => 'Stock Information Updated']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        // $user = ProductInformation::find($id);
        // $user->delete();
        // return true;
    }
    public function active($id)
    {
        $data         = StockIn::find($id);
        $data->status = 1;
        $data->save();
        return true;
    }
}
