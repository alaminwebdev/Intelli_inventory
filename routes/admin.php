<?php
use App\Http\Controllers\Admin\DefaultController;

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/received-products', 'DashboardController@receivedProducts')->name('dashboard.received-products');
// Route::get('/requisition-products', 'DashboardController@requisitionProducts')->name('dashboard.requisition-products');
Route::get('/stock-in-products', 'DashboardController@stockInProducts')->name('dashboard.stock-in-products');
// Route::get('/distributed-products', 'DashboardController@distributedProducts')->name('dashboard.distributed-products');

Route::post('/total-products-in-requisition-by-section', 'DashboardController@getProductsInRequisitionBySection')->name('dashboard.total-products-in-requisition-by-section');
Route::post('/requisition-info-by-department', 'DashboardController@getRequisitionInfoByDepartment')->name('dashboard.requisition-info-by-department');

Route::post('/total-requisition-products', 'DashboardController@getTotalRequisitionProducts')->name('dashboard.total-requisition-products');
Route::post('/total-stock-products', 'DashboardController@getTotalStockProducts')->name('dashboard.total-stock-products');
Route::post('/get-distributed-products', 'DashboardController@getDistributedProducts')->name('dashboard.get-distributed-products');


Route::name('site-setting-management.')->prefix('site-setting-management')->namespace('SiteSettingManagement')->group(base_path('routes/admin/site_setting_management.php'));
Route::name('role-management.')->prefix('role-management')->namespace('RoleManagement')->group(base_path('routes/admin/role_management.php'));
Route::name('profile-management.')->prefix('profile-management')->namespace('ProfileManagement')->group(base_path('routes/admin/profile_management.php'));
Route::name('user-management.')->prefix('user-management')->namespace('UserManagement')->group(base_path('routes/admin/user_management.php'));
Route::name('member-management.')->prefix('member-management')->namespace('MemberManagement')->group(base_path('routes/admin/member_management.php'));



// Default Controller 
Route::get('/get-products-by-type', [DefaultController::class, 'getProductsByType'])->name('get.products.by.type');
Route::get('/get-sections-by-department', [DefaultController::class, 'getSectionsByDepartment'])->name('get.sections.by.department');
Route::get('/get-products-by-section-requisition', [DefaultController::class, 'getProductsBySectionRequisition'])->name('get.products.by.section.requisition');
Route::get('/get-employee-by-id', [DefaultController::class, 'getEmployeeById'])->name('get.employee.by.id');
Route::get('/get-sections-requisitions-by-department', [DefaultController::class, 'getSectionsRequisitionsByDepartment'])->name('get.sections.requisitions.by.department');
Route::get('/get-stock-in-details-by-stock-id', [DefaultController::class, 'getStockInDetailsByStockId'])->name('get.stock.in.details.by.stock.id');
Route::get('/get-requistion-details-by-id', [DefaultController::class, 'getRequistionDetailsById'])->name('get.requistion.details.by.id');
Route::get('/get-distribute-requistion-by-status', [DefaultController::class, 'getDistributeRequistionByStatus'])->name('get.distribute.requistion.by.status');
Route::get('/get-requistion-by-status', [DefaultController::class, 'getRequistionByStatus'])->name('get.requistion.by.status');
Route::get('/get-requistion-by-status-for-recommender', [DefaultController::class, 'getRequistionByStatusForRecommender'])->name('get.requistion.by.status.for.recommender');


// System Setup
include 'admin/system_setup.php';

// Employee Management
include 'admin/employee_management.php';

// Product Management
include 'admin/product_management.php';

// Requisition Management
include 'admin/requisition_management.php';

// Report Management
include 'admin/report_management.php';