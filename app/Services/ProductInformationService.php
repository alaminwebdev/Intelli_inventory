<?php

namespace App\Services;

use App\Models\ProductInformation;
use App\Models\ProductType;
use App\Services\IService;
use Illuminate\Http\Request;

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
            $data = ProductInformation::whereIn('id', $ids)->where('status', 1)->latest()->get();;
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

    public function getProductTypeAndProducts(){
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
