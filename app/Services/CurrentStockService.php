<?php

namespace App\Services;

use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class CurrentStockService
 * @package App\Services
 */
class CurrentStockService
{

    public function getCurrentStock()
    {
        try {
            $data = DB::table('stock_ins')
                ->join('stock_in_details', 'stock_in_details.stock_in_id', 'stock_ins.id')
                ->join('product_information', 'product_information.id', 'stock_in_details.product_information_id')
                ->leftJoin('units', 'units.id', 'product_information.unit_id')
                // ->where(function ($q) {
                //     $q->orWhereNull('stock_in_details.expire_date');
                //     $q->orWhereDate('stock_in_details.expire_date', '>=', date('Y-m-d H:i:s'));
                // })
                ->where(function ($q) {
                    $q->where('stock_in_details.available_qty', '>', 0);
                })
                ->where('stock_ins.status', 1)
                ->select(
                    'stock_in_details.product_information_id as product_id',
                    'product_information.name as product_name',
                    'units.name as unit_name',
                    DB::raw('sum(stock_in_details.available_qty) as available_qty'),
                )
                ->groupBy('stock_in_details.product_information_id','product_information.name', 'units.name')
                // ->orderBy('stock_in_details.updated_at', 'desc')
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByProductWithSum($product_id)
    {
        try {
            $data = StockIn::join('stock_in_details', 'stock_in_details.stock_in_id', 'stock_ins.id')
                ->join('product_information', 'product_information.id', 'stock_in_details.product_information_id')
                ->leftJoin('units', 'units.id', 'product_information.unit_id')
                ->where(function ($q) {
                    $q->orWhereNull('stock_in_details.expire_date');
                    $q->orWhereDate('stock_in_details.expire_date', '>=', date('Y-m-d H:i:s'));
                })
                ->where(function ($q) {
                    $q->where('stock_in_details.available_qty', '>', 0);
                })
                ->where('stock_ins.status', 1)
                ->where('stock_in_details.product_information_id', $product_id)
                ->select(
                    'stock_in_details.product_information_id as product_id',
                    'product_information.name as product_name',
                    'units.name as unit_name',
                    DB::raw('sum(stock_in_details.available_qty) as available_qty'),
                )
                ->groupBy(
                    'stock_in_details.product_information_id',
                )
                ->first();

            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
