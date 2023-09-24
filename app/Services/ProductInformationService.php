<?php

namespace App\Services;

use App\Models\ProductInformation;
use App\Models\ProductPoInfo;
use App\Models\ProductType;
use App\Models\StockInDetail;
use App\Services\IService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductInformationService
 * @package App\Services
 */
class ProductInformationService implements IService
{

    public function getAll()
    {
        try {
            $data = ProductInformation::join('product_types', 'product_types.id', 'product_information.product_type_id')
                ->join('units', 'units.id', 'product_information.unit_id')
                ->select(
                    'product_information.*',
                    'units.name as unit',
                    'product_types.name as product_type',
                )
                ->latest()
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getSpecificProducts($ids = null)
    {
        try {
            $data = ProductInformation::whereIn('id', $ids)->where('status', 1)->latest()->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getPoProducts($po_no, $product_ids = null)
    {
        try {

            // $data = StockInDetail::join('product_information', 'product_information.id', 'stock_in_details.product_information_id')
            //     ->leftjoin('units', 'units.id', 'product_information.unit_id')
            //     ->where('stock_in_details.po_no', '=',  $po_no)
            //     ->when($product_ids, function ($query, $product_ids) {
            //         if ($product_ids != null) {
            //             $query->whereIn('stock_in_details.product_information_id', $product_ids);
            //         }
            //     })
            //     ->where('stock_in_details.reject_qty', '>', 0)
            //     ->select(
            //         'product_information.id as product_id',
            //         'product_information.name as product',
            //         'units.name as unit',
            //         // 'stock_in_details.po_qty as po_qty',
            //         // 'stock_in_details.receive_qty as receive_qty',
            //         DB::raw('MAX(stock_in_details.po_qty) as po_qty'),
            //         DB::raw('sum(stock_in_details.receive_qty) as receive_qty'),
            //         DB::raw('sum(stock_in_details.reject_qty) as reject_qty'),
            //     )
            //     ->groupBy('stock_in_details.product_information_id')
            //     ->get();

            $data =  DB::table('product_information')
                ->select(
                    'product_information.id as product_id',
                    'product_information.name as product',
                    'units.name as unit',
                    DB::raw('MAX(stock_in_details.po_qty) as po_qty'),
                    DB::raw('SUM(stock_in_details.receive_qty) as receive_qty'),
                    DB::raw('MIN(stock_in_details.reject_qty) as reject_qty')
                )
                ->leftJoin('stock_in_details', 'product_information.id', '=', 'stock_in_details.product_information_id')
                ->leftJoin('units', 'units.id', '=', 'product_information.unit_id')
                ->where('stock_in_details.po_no', '=', $po_no)
                ->when($product_ids, function ($query, $product_ids) {
                    if ($product_ids != null) {
                        $query->whereIn('stock_in_details.product_information_id', $product_ids);
                    }
                })
                // ->where('stock_in_details.reject_qty', '>', 0)
                ->groupBy('product_information.id', 'product_information.name', 'units.name')
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getProductsByTypeId($id)
    {
        try {
            $data = ProductInformation::where('product_type_id', $id)->where('status', 1)->latest()->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getProductTypeAndProducts()
    {
        try {
            $productTypeData    = [];
            $product_types      = ProductType::where('status', 1)->latest()->get();

            foreach ($product_types as $item) {
                $productType = [
                    'id'        => $item->id,
                    'name'      => $item->name,
                    'products'  => [],
                ];

                // Query products for this product type and push them into the products array
                $products = ProductInformation::where('product_type_id', $item->id)
                    ->latest()
                    ->get();

                if (count($products) > 0) {

                    foreach ($products as $product) {
                        $productType['products'][$product->id] = [
                            'id'                => $product->id,
                            'name'              => $product->name,
                            'unit'              => $product->unit->name,
                        ];
                    }
                    // Push this product type data into the main array AFTER adding products
                    $productTypeData[] = $productType;
                }
            }
            return $productTypeData;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {
            $data               = new ProductInformation();
            $data->code             = $request->code;
            $data->name             = $request->name;
            $data->product_type_id  = $request->product_type_id;
            $data->unit_id          = $request->unit_id;
            $data->status           = $request->status ?? 0;
            $data->save();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
        $data = ProductInformation::find($id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        try {
            $data                   = ProductInformation::find($id);
            $data->code             = $request->code;
            $data->name             = $request->name;
            $data->product_type_id  = $request->product_type_id;
            $data->unit_id          = $request->unit_id;
            $data->status           = $request->status ?? 0;
            $data->save();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $user = ProductInformation::find($id);
        $user->delete();
        return true;
    }
}
