<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\ProductInformation;
use App\Models\ProductType;
use App\Models\SectionRequisition;
use App\Models\SectionRequisitionDetails;
use App\Services\IService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class SectionRequisitionService
 * @package App\Services
 */
class SectionRequisitionService implements IService
{

    public function getAll($section_id = null, $status = null, $section_ids = null, $statuses = null)
    {
        try {
            $query = SectionRequisition::with(
                'section:id,name,department_id',
                'section.department:id,name',
            )
                ->latest();
            if ($section_id) {
                $query->where('section_id', $section_id);
            }
            if ($status) {
                $query->where('status', $status);
            }
            if ($section_ids) {
                $query->whereIn('section_id', $section_ids);
            }
            if ($statuses) {
                $query->whereIn('status', $statuses);
            }
            $data = $query->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getAllBySections($section_ids, $status)
    {
        try {
            $data = SectionRequisition::whereIn('section_id', $section_ids)->where('status', $status)->whereNull('department_requisition_id')->latest()->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getRequisitionProductsByIDs($section_ids)
    {
        try {

            $data =  DB::table('section_requisition_details')
                ->whereIn('section_requisition_details.section_requisition_id', $section_ids)
                ->select(
                    'section_requisition_details.product_id',
                    DB::raw('SUM(section_requisition_details.current_stock) as total_current_stock'),
                    DB::raw('SUM(section_requisition_details.demand_quantity) as total_demand_quantity'),
                )
                ->groupBy('section_requisition_details.product_id')
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUniqueRequisitionNo()
    {
        do {
            $requisition_no = rand(10000, 99999);
        } while (SectionRequisition::where('requisition_no', $requisition_no)->exists());

        return $requisition_no;
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->input('data');
            $sectionRequisition = new SectionRequisition();

            $sectionRequisition->requisition_no = $data['requisitionNumber'];
            $sectionRequisition->section_id     = $data['sectionId'];
            $sectionRequisition->user_id        = Auth::id();
            $sectionRequisition->status         = 0;

            if ($sectionRequisition->save()) {
                $productData = $data['productData'];
                foreach ($productData as $productId => $productDetails) {
                    // Retrieve data for the current product
                    $currentStock   = $productDetails['current_stock'] ?? null;
                    $demandQuantity = $productDetails['demand_quantity'] ?? null;
                    $remarks        = $productDetails['remarks'] ?? null;


                    if ($demandQuantity !== null && $demandQuantity > 0) {
                        // Store Data into SectionRequisitionDetails
                        $sectionRequisitionDetails                          = new SectionRequisitionDetails();
                        $sectionRequisitionDetails->section_requisition_id  = $sectionRequisition->id;
                        $sectionRequisitionDetails->requisition_no          = $data['requisitionNumber'];
                        $sectionRequisitionDetails->product_id              = $productId;
                        $sectionRequisitionDetails->current_stock           = $currentStock;
                        $sectionRequisitionDetails->demand_quantity         = $demandQuantity;
                        $sectionRequisitionDetails->remarks                 = $remarks;
                        $sectionRequisitionDetails->status                  = 0;
                        $sectionRequisitionDetails->save();
                    }
                }
            }
            DB::commit();
            return response()->json(['success' => 'Requisition Information Inserted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getByID($id)
    {
        $data = SectionRequisition::find($id);
        return $data;
    }

    public function getProductRequisitionInfoByID($requistion_id)
    {
        try {

            $data = SectionRequisitionDetails::join('product_information', 'product_information.id', 'section_requisition_details.product_id')
                ->where('section_requisition_id', $requistion_id)
                ->select(
                    'section_requisition_details.current_stock as current_stock',
                    'section_requisition_details.demand_quantity as demand_quantity',
                    'section_requisition_details.recommended_quantity as recommended_quantity',
                    'section_requisition_details.final_approve_quantity as final_approve_quantity',
                    'section_requisition_details.remarks as remarks',
                    'product_information.name as product'
                )
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getRequisitionProductsWithTypeById($requistion_id){

        $productTypeData    = [];
        $product_types      = ProductType::latest()->where('status', 1)->get();

        foreach ($product_types as $item) {
            $productType = [
                'id'        => $item->id,
                'name'      => $item->name,
                'products'  => [],
            ];

            // Query products for this product type and push them into the products array
            $productIds = ProductInformation::where('product_type_id', $item->id)
                ->latest()
                ->pluck('id');

            $requisitionProducts = SectionRequisitionDetails::where('section_requisition_id', $requistion_id)
                ->whereIn('product_id', $productIds)
                ->get();

            if (count($requisitionProducts) > 0) {

                foreach ($requisitionProducts as $product) {

                    $productType['products'][$product->product_id] = [
                        'product_id'                => $product->product_id,
                        'product_name'              => $product->product->name,
                        'current_stock'             => $product->current_stock,
                        'demand_quantity'           => $product->demand_quantity,
                        'remarks'                   => $product->remarks,
                        'recommended_quantity'      => $product->recommended_quantity,
                        'recommended_remarks'       => $product->recommended_remarks,
                        'final_approve_quantity'    => $product->final_approve_quantity,
                        'final_approve_remarks'     => $product->final_approve_remarks,
                        'available_quantity'        => $product->StockDetail->sum('available_qty')
                    ];
                }

                // Push this product type data into the main array AFTER adding products
                $productTypeData[] = $productType;
            }
        }
        return $productTypeData;
    }

    public function update(Request $request, $id)
    {
        // try {
        //     $data                 = Section::find($id);
        //     $data->name           = $request->name;
        //     $data->department_id  = $request->department_id;
        //     $data->sort           = $request->sort;
        //     $data->status         = $request->status;
        //     $data->save();
        //     return true;
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }

    public function delete($id)
    {
        // $user = Section::find($id);
        // $user->delete();
        // return true;
    }
}
