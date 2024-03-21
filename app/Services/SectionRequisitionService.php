<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Distribute;
use App\Models\Employee;
use App\Models\ProductInformation;
use App\Models\ProductType;
use App\Models\Section;
use App\Models\SectionRequisition;
use App\Models\SectionRequisitionDetails;
use App\Services\IService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ProductAvailabilityService;

/**
 * Class SectionRequisitionService
 * @package App\Services
 */
class SectionRequisitionService implements IService
{
    protected $productAvailabilityService;

    public function __construct(ProductAvailabilityService $productAvailabilityService)
    {
        $this->productAvailabilityService = $productAvailabilityService;
    }

    public function getAll($section_id = null, $status = null, $section_ids = null, $statuses = null, $take = null, $from_date = null, $to_date = null)
    {
        try {
            $query = SectionRequisition::with(
                'section:id,name,department_id',
                'section.department:id,name',
            );
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
            if ($take) {
                $query->take($take);
            }
            if ($from_date && $to_date && in_array(3, $statuses)) {
                $query->whereBetween('final_approve_at', [
                    date('Y-m-d', strtotime($from_date)) . ' 00:00:00',
                    date('Y-m-d', strtotime($to_date)) . ' 23:59:59'
                ]);
            } elseif ($from_date && $to_date && in_array(4, $statuses)) {
                $query->whereBetween('distribute_at', [
                    date('Y-m-d', strtotime($from_date)) . ' 00:00:00',
                    date('Y-m-d', strtotime($to_date)) . ' 23:59:59'
                ]);
            } elseif ($from_date && $to_date) {
                $query->whereBetween('created_at', [
                    date('Y-m-d', strtotime($from_date)) . ' 00:00:00',
                    date('Y-m-d', strtotime($to_date)) . ' 23:59:59'
                ]);
            }

            $data = $query->latest()->get();
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
        // Increase max_execution_time to 2 hours (7200 seconds)
        ini_set('max_execution_time', 7200);

        // Set max_input_time to 2 hours (7200 seconds)
        ini_set('max_input_time', 7200);
        
        // Increase memory_limit to unlimited
        ini_set('memory_limit', '-1'); // '-1' indicates unlimited memory

        // Set max_input_vars to 5000
        ini_set('max_input_vars', 5000);

        DB::beginTransaction();
        try {

            $data = $request->input('data');
            $sectionRequisition = new SectionRequisition();

            $sectionRequisition->requisition_no = $this->getUniqueRequisitionNo(); //$data['requisitionNumber'];
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
                        $sectionRequisitionDetails->requisition_no          = $sectionRequisition->requisition_no; //$data['requisitionNumber'];
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

    public function getProductRequisitionInfoByID($requistion_id = null, $section_ids = null, $take = null, $status = null, $days = null)
    {
        try {

            $data = SectionRequisitionDetails::join('product_information', 'product_information.id', 'section_requisition_details.product_id')
                // ->where('section_requisition_id', $requistion_id)
                ->leftjoin('units', 'units.id', 'product_information.unit_id')
                ->join('section_requisitions', 'section_requisitions.id', 'section_requisition_details.section_requisition_id')
                ->join('sections', 'sections.id', 'section_requisitions.section_id')
                ->when($requistion_id, function ($q, $requistion_id) {
                    $q->where('section_requisition_id', $requistion_id);
                })
                ->when($section_ids, function ($q, $section_ids) {
                    $q->whereIn('section_requisitions.section_id', $section_ids);
                })
                ->when($status, function ($q, $status) {
                    $q->where('section_requisitions.status', $status);
                })
                ->when($take, function ($q, $take) {
                    $q->take($take);
                })
                ->when($days, function ($q, $days) {
                    $days_ago = now()->subDays($days);
                    $q->whereDate('section_requisition_details.updated_at', '>=', $days_ago);
                })
                ->orderBy('section_requisition_details.updated_at', 'desc')
                ->select(
                    'section_requisitions.requisition_no as requisition_no',
                    'section_requisition_details.current_stock as current_stock',
                    'section_requisition_details.demand_quantity as demand_quantity',
                    'section_requisition_details.recommended_quantity as recommended_quantity',
                    'section_requisition_details.verify_quantity as verify_quantity',
                    'section_requisition_details.final_approve_quantity as final_approve_quantity',
                    'product_information.name as product',
                    'units.name as unit',
                    'sections.name as section',
                    'section_requisitions.status as status',
                    DB::raw('COALESCE(section_requisition_details.final_approve_remarks, section_requisition_details.verify_remarks, section_requisition_details.recommended_remarks, section_requisition_details.remarks) as remarks'),
                )
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getRequisitionProductsWithTypeById($requistion_id, $editData = null)
    {

        $productTypeData    = [];
        $product_types      = ProductType::latest()->where('status', 1)->get();

        if ($editData) {
            $requisition_ids = SectionRequisition::where('section_id', $editData->section_id)
                ->where('id', '!=', $editData->id)
                ->pluck('id');
        } else {
            $requisition_ids = [];
        }

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

            $last_distribute_qty = 0;

            $requisitionProducts = SectionRequisitionDetails::where('section_requisition_id', $requistion_id)
                ->whereIn('product_id', $productIds)
                ->get();


            if (count($requisitionProducts) > 0) {

                foreach ($requisitionProducts as $product) {

                    // Get the last distribute_quantity for this product_id
                    if ($requisition_ids) {
                        $last_distribute_item = Distribute::whereIn('section_requisition_id', $requisition_ids)
                            ->where('product_id', $product->product_id)
                            ->latest()
                            ->first(['id', 'product_id', 'distribute_quantity']);


                        if ($last_distribute_item) {
                            $last_distribute_qty = $last_distribute_item->distribute_quantity;
                        } else {
                            $last_distribute_qty = 0;
                        }
                    }

                    // Get the total distribute_quantity for this product_id and section_requisition_id
                    $totalDistributeQuantity = Distribute::where('section_requisition_id', $requistion_id)
                        ->where('product_id', $product->product_id)
                        ->sum('distribute_quantity');



                    $availableStock = $this->productAvailabilityService->getAvailableStock($product->product_id, $requistion_id);

                    // $availableQty = 0;
                    // // Iterate over each StockInDetail in the collection
                    // foreach ($product->StockDetail as $stockDetail) {
                    //     $stockInStatus = $stockDetail->stockIn->status;

                    //     // Check the status of the associated StockIn and calculate available_qty only when the status is 1
                    //     if ($stockInStatus == 1) {
                    //         $availableQty += $stockDetail->available_qty;
                    //     }
                    // }

                    $productType['products'][$product->product_id] = [
                        'product_id'                => $product->product_id,
                        'product_name'              => $product->product->name,
                        'current_stock'             => $product->current_stock,
                        'demand_quantity'           => $product->demand_quantity,
                        'remarks'                   => $product->remarks,
                        'recommended_quantity'      => $product->recommended_quantity,
                        'recommended_remarks'       => $product->recommended_remarks,
                        'verify_quantity'           => $product->verify_quantity,
                        'verify_remarks'            => $product->verify_remarks,
                        'final_approve_quantity'    => $product->final_approve_quantity,
                        'final_approve_remarks'     => $product->final_approve_remarks,
                        'available_quantity'        => $availableStock['available_qty'] ?? 0,
                        'last_distribute_qty'       => $last_distribute_qty,
                        'totalDistributeQuantity'   => $totalDistributeQuantity ?? 0
                    ];
                }

                // Push this product type data into the main array AFTER adding products
                $productTypeData[] = $productType;
            }
        }
        return $productTypeData;
    }

    public function getMostRequestedProducts($section_ids = null, $request = null, $take = null, $days = null)
    {

        // Initialize an empty array to store the formatted data
        $formattedData = [];

        $totalSectionRequisition = SectionRequisition::when($section_ids, function ($q, $section_ids) {
            $q->whereIn('section_id', $section_ids);
        })
            ->when($request, function ($q, $request) {
                if (($request['date_from'] != null || $request['date_to'] != null)) {
                    $fromDate   = date('Y-m-d', strtotime($request['date_from']));
                    $toDate     = date('Y-m-d', strtotime($request['date_to']));
                    $q->whereDate('updated_at', '>=', $fromDate);
                    $q->whereDate('updated_at', '<=', $toDate);
                }
            })
            ->when($days, function ($q, $days) {
                $days_ago = now()->subDays($days);
                $q->whereDate('updated_at', '>=', $days_ago);
            })
            ->pluck('id');


        if ($totalSectionRequisition) {
            $mostRequestedProducts = SectionRequisitionDetails::whereIn('section_requisition_id', $totalSectionRequisition)
                ->join('product_information', 'product_information.id', 'section_requisition_details.product_id')
                ->leftjoin('units', 'units.id', 'product_information.unit_id')
                ->select(
                    'product_id',
                    'product_information.name as product',
                    'units.name as unit',
                    DB::raw('SUM(demand_quantity) as total_demand_qty')
                )
                ->groupBy('section_requisition_details.product_id', 'product_information.name', 'units.name')
                ->orderByDesc('total_demand_qty')
                ->when($take, function ($q, $take) {
                    $q->take($take);
                })
                // ->take(10)
                ->get();

            // Modify the product names to keep only the unique first word and append an index when needed
            $uniqueProducts = [];

            // Iterate through the retrieved data and format it
            foreach ($mostRequestedProducts as $product) {
                // $formattedData[] = [
                //     'product'   => $product->product . ' (' . $product->unit . ')',
                //     'quantity'  => (int) $product->total_demand_qty,
                // ];
                $firstWord = strtok($product->product, ' ');


                if (!isset($uniqueProducts[$firstWord])) {
                    $uniqueProducts[$firstWord] = [
                        'product_short'     => $firstWord,
                        'product'           => $product->product . ' (' . $product->unit . ')',
                        'quantity'          => (int) $product->total_demand_qty,
                    ];
                } else {

                    // If the first word already exists, append an index to the first word
                    $index = 1;
                    while (isset($uniqueProducts[$firstWord . '_' . $index])) {
                        $index++;
                    }

                    $uniqueProducts[$firstWord . '_' . $index] = [
                        'product_short'     => $firstWord . '_' . $index,
                        'product'           => $product->product . ' (' . $product->unit . ')',
                        'quantity'          => (int) $product->total_demand_qty,
                    ];
                }
            }
            // Convert the uniqueProducts array back to an array of values
            $formattedData = array_values($uniqueProducts);
        }

        // Return the formatted data
        return $formattedData;
    }
    public function getProductsInRequisitionBySection($request = null, $section_ids = null)
    {
        // Initialize an empty array to store the formatted data
        $formattedData = [];

        // Initialize an array to store section totals
        $sectionTotals = [];

        // Retrieve distinct section_ids based on your conditions
        $distinctSectionIds = SectionRequisition::when($section_ids, function ($q) use ($section_ids) {
            $q->whereIn('section_id', $section_ids);
        })->distinct('section_id')->limit(5)->pluck('section_id');

        $totalSectionRequisition = SectionRequisition::whereIn('section_id', $distinctSectionIds)
            ->when($request, function ($q, $request) {
                if (($request['date_from'] != null || $request['date_to'] != null)) {
                    $fromDate   = date('Y-m-d', strtotime($request['date_from']));
                    $toDate     = date('Y-m-d', strtotime($request['date_to']));
                    $q->whereDate('updated_at', '>=', $fromDate);
                    $q->whereDate('updated_at', '<=', $toDate);
                } else {
                    $today_date = date('Y-m-d');
                    $q->whereDate('updated_at', $today_date);
                }
            })
            ->get();

        if ($totalSectionRequisition) {
            foreach ($totalSectionRequisition as $requisition) {
                $total_products = SectionRequisitionDetails::where('section_requisition_id', $requisition->id)->count();
                $sectionName = $requisition->section->name;

                // Increment section totals
                if (!isset($sectionTotals[$sectionName])) {
                    $sectionTotals[$sectionName] = [
                        'totalRequisitions' => 0,
                        'totalProducts'     => 0,
                    ];
                }

                $sectionTotals[$sectionName]['totalRequisitions']++;
                $sectionTotals[$sectionName]['totalProducts'] += $total_products;
            }

            // Format the data with unique section names
            $uniqueSectionName = [];
            foreach ($sectionTotals as $sectionName => $totals) {

                $firstWord = strtok($sectionName, ' ');

                if (!isset($uniqueSectionName[$firstWord])) {
                    $uniqueSectionName[$firstWord] = 1;
                    $formattedData[] = [
                        'section'           => $sectionName,
                        'section_short'     => $firstWord,
                        'totalRequisitions' => $totals['totalRequisitions'],
                        'totalProducts'     => $totals['totalProducts'],
                    ];
                } else {
                    // If the first word already exists, append an index to the first word
                    $index = $uniqueSectionName[$firstWord]++;
                    $formattedData[] = [
                        'section'           => $sectionName,
                        'section_short'     => $firstWord . '_' . $index,
                        'totalRequisitions' => $totals['totalRequisitions'],
                        'totalProducts'     => $totals['totalProducts'],
                    ];
                }
            }
        }

        //dd($formattedData);
        // Return the formatted data
        return $formattedData;
    }

    public function getRequisitionInfoByDepartment($request = null)
    {
        // Initialize an empty array to store the formatted data
        $formattedData = [];

        $departments = Department::where('status', 1)->get();

        foreach ($departments as $department) {
            // Initialize department total requisitions
            $departmentTotalRequisitions = 0;

            $section_ids = Section::where('department_id', $department->id)
                ->where('status', 1)
                ->latest()
                ->take(5)
                ->pluck('id');

            $totalSectionRequisitions = SectionRequisition::whereIn('section_id', $section_ids)
                ->when($request, function ($q, $request) {
                    if ($request['date_from'] !== null || $request['date_to'] !== null) {
                        $fromDate = date('Y-m-d', strtotime($request['date_from']));
                        $toDate = date('Y-m-d', strtotime($request['date_to']));
                        $q->whereDate('updated_at', '>=', $fromDate)
                            ->whereDate('updated_at', '<=', $toDate);
                    } else {
                        $today_date = date('Y-m-d');
                        $q->whereDate('updated_at', $today_date);
                    }
                })
                ->get();

            if ($totalSectionRequisitions->isNotEmpty()) {
                // Increment section requisitions
                if (!isset($formattedData[$department->name])) {

                    $formattedData[$department->name] = [
                        // 'department' => strtok($department->name, ' '),
                        'department' => $department->name,
                        'totalRequisition' => 0,
                    ];
                }


                // dd($totalSectionRequisitions);
                foreach ($totalSectionRequisitions as $requisition) {
                    $sectionName = $requisition->section->name;

                    // Increment department total requisitions
                    $departmentTotalRequisitions++;

                    $formattedData[$department->name][$sectionName] = isset($formattedData[$department->name][$sectionName]) ? $formattedData[$department->name][$sectionName] + 1 : 1;
                }

                // Update department total requisitions
                $formattedData[$department->name]['totalRequisition'] = $departmentTotalRequisitions;
            }
        }


        // Convert the formatted data to a numerically indexed array
        $data = array_values($formattedData);

        // Sort the array based on 'totalRequisition' in descending order
        usort($data, function ($a, $b) {
            return $b['totalRequisition'] - $a['totalRequisition'];
        });

        // Return the top 5 elements
        $data = array_slice($data, 0, 3);
        return $data;
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
