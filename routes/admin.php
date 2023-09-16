<?php
use App\Http\Controllers\Admin\DefaultController;

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

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