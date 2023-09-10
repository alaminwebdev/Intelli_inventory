<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/cache_clear', function () {
    try {
        Artisan::call('config:cache');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
    } catch (\Exception $e) {
        dd($e);
    }
});
Route::get('/user_registration', function () {
    return view('user_registration');
});
Route::get('/', function () {
    return redirect()->route('login');
});
//Reset Password
Route::get('reset/password', 'Backend\PasswordResetController@resetPassword')->name('reset.password');
Route::post('check/email', 'Backend\PasswordResetController@checkEmail')->name('check.email');
Route::get('check/name', 'Backend\PasswordResetController@checkName')->name('check.name');
Route::get('check/code', 'Backend\PasswordResetController@checkCode')->name('check.code');
Route::post('submit/check/code', 'Backend\PasswordResetController@submitCode')->name('submit.check.code');
Route::get('new/password', 'Backend\PasswordResetController@newPassword')->name('new.password');
Route::post('store/new/password', 'Backend\PasswordResetController@newPasswordStore')->name('store.new.password');

// Route::group(['middleware' => 'prevent.back'], function(){
Auth::routes();
Route::middleware(['auth'])->group(function () {
    // Route::middleware(['jisf.auth'])->group(function () {

    Route::get('/home', 'Backend\HomeController@index')->name('dashboard');
    // Route::get('/approved-policy-pie-chart', 'Backend\HomeController@approvedPolicyPieChart')->name('approved-policy-pie-chart');
    // Route::get('/ongoing-policy-chart', 'Backend\HomeController@ongoingPolicyChart')->name('ongoing-policy-chart');
    // Route::get('/comparison-approve-ongoing-policy-chart', 'Backend\HomeController@comparisonApproveOngoingPolicyChart')->name('comparison-approve-ongoing-policy-chart');

    //Route::group(['middleware' => ['permission']], function () {

    Route::prefix('menu')->group(function () {
        Route::get('/view', 'Backend\MenuManagement\Menu\MenuController@index')->name('menu');
        Route::get('/add', 'Backend\MenuManagement\Menu\MenuController@add')->name('menu.add');
        Route::post('/store', 'Backend\MenuManagement\Menu\MenuController@store')->name('menu.store');
        Route::get('/edit/{id}', 'Backend\MenuManagement\Menu\MenuController@edit')->name('menu.edit');
        Route::post('/update/{id}', 'Backend\MenuManagement\Menu\MenuController@update')->name('menu.update');
        Route::get('/subparent', 'Backend\MenuManagement\Menu\MenuController@getSubParent')->name('menu.getajaxsubparent');

        Route::get('/icon', 'Backend\MenuManagement\Menu\MenuIconController@index')->name('menu.icon');
        Route::post('icon/store', 'Backend\MenuManagement\Menu\MenuIconController@store')->name('menu.icon.store');
        Route::get('icon/edit', 'Backend\MenuManagement\Menu\MenuIconController@edit')->name('menu.icon.edit');
        Route::post('icon/update/{id}', 'Backend\MenuManagement\Menu\MenuIconController@update')->name('menu.icon.update');
        Route::post('icon/delete', 'Backend\MenuManagement\Menu\MenuIconController@delete')->name('menu.icon.delete');
    });

    Route::post('/data/statuschange', 'Backend\DefaultController@statusChange')->name('table.status.change');
    Route::post('/data/delete', 'Backend\DefaultController@delete')->name('table.data.delete');
    Route::get('/sub/menu', 'Backend\DefaultController@SubMenu')->name('table.data.submenu');

    // Route::get('/search-policy', 'Backend\HomeController@searchPolicy')->name('search.policy');
    // Route::get('/policy=details/{id}', 'Backend\HomeController@policyDetails')->name('policy.details');

    Route::prefix('user')->group(function () {
        Route::get('/', 'Backend\UserManagement\User\UserController@index')->name('user');
        Route::get('/add', 'Backend\UserManagement\User\UserController@userAdd')->name('user.add');
        Route::post('/store', 'Backend\UserManagement\User\UserController@userStore')->name('user.store');
        Route::get('/edit/{id}', 'Backend\UserManagement\User\UserController@userEdit')->name('user.edit');
        Route::post('/update/{id}', 'Backend\UserManagement\User\UserController@updateUser')->name('user.update');
        Route::post('/delete', 'Backend\UserManagement\User\UserController@deleteUser')->name('user.delete');

        Route::get('/user/status/', 'Backend\UserManagement\User\UserController@userStatus')->name('user.status.change');

        Route::get('/role', 'Backend\UserManagement\Role\RoleController@index')->name('user.role');
        Route::post('/role/store', 'Backend\UserManagement\Role\RoleController@storeRole')->name('user.role.store');
        Route::get('/role/edit', 'Backend\UserManagement\Role\RoleController@getRole')->name('user.role.edit');
        Route::post('/role/update/{id}', 'Backend\UserManagement\Role\RoleController@updateRole')->name('user.role.update');
        Route::post('/role/delete', 'Backend\UserManagement\Role\RoleController@deleteRole')->name('user.role.delete');

        Route::get('/permission', 'Backend\UserManagement\MenuPermission\MenuPermissionController@index')->name('user.permission');
        Route::post('/permission/store', 'Backend\UserManagement\MenuPermission\MenuPermissionController@storePermission')->name('user.permission.store');

        Route::get('/designation', 'Backend\UserManagement\Designation\DesignationController@index')->name('user.designation');
        Route::get('/designation/add', 'Backend\UserManagement\Designation\DesignationController@add')->name('user.designation.add');
        Route::post('/designation/store', 'Backend\UserManagement\Designation\DesignationController@store')->name('user.designation.store');
        Route::get('/designation/edit/{id}', 'Backend\UserManagement\Designation\DesignationController@edit')->name('user.designation.edit');
        Route::post('/designation/update/{id}', 'Backend\UserManagement\Designation\DesignationController@update')->name('user.designation.update');
        Route::post('/designation/delete', 'Backend\UserManagement\Designation\DesignationController@delete')->name('user.designation.delete');

        // user logs and ministry wise user add
        // Route::get('/log', 'UserController@userLog')->name('user.log');
        // Route::get('/ministry', 'UserController@userMinistry')->name('user.ministry');
        // Route::get('/ministry/add', 'UserController@userMinistryAdd')->name('user.ministry.add');
        // Route::post('/ministry/store', 'UserController@userMinistryStore')->name('user.ministry.store');
        // Route::get('/ministry/edit/{id}', 'UserController@userMinistryEdit')->name('ministry.user.edit');
        // Route::post('/ministry/update/{id}', 'UserController@userMinistryUpdate')->name('user.ministry.update');
        // Route::post('/ministry/delete', 'UserController@userMinistryDelete')->name('ministry.user.delete');
    });

    Route::prefix('profile-management')->group(function () {
        //Change Password
        Route::get('change/password', 'Backend\ProfileManagement\PasswordChangeController@changePassword')->name('profile-management.change.password');
        Route::post('store/password', 'Backend\ProfileManagement\PasswordChangeController@storePassword')->name('profile-management.store.password');
        //Profile
        Route::get('change/profile', 'Backend\ProfileManagement\ProfileChangeController@changeProfile')->name('profile-management.change.profile');
        Route::post('store/profile', 'Backend\ProfileManagement\ProfileChangeController@storeProfile')->name('profile-management.store.profile');
    });

    Route::prefix('frontend-menu')->group(function () {
        //Post
        Route::get('/post/view', 'Backend\SiteMenu\Page\PageController@view')->name('frontend-menu.post.view');
        Route::get('/post/add', 'Backend\SiteMenu\Page\PageController@add')->name('frontend-menu.post.add');
        Route::post('/post/store', 'Backend\SiteMenu\Page\PageController@store')->name('frontend-menu.post.store');
        Route::get('/post/edit/{id}', 'Backend\SiteMenu\Page\PageController@edit')->name('frontend-menu.post.edit');
        Route::post('/post/update/{id}', 'Backend\SiteMenu\Page\PageController@update')->name('frontend-menu.post.update');
        Route::post('/post/delete', 'Backend\SiteMenu\Page\PageController@destroy')->name('frontend-menu.post.destroy');
        //Frontend Menu
        Route::get('/menu/view', 'Backend\SiteMenu\FrontendMenu\FrontendMenuController@view')->name('frontend-menu.menu.view');
        Route::get('/menu/add', 'Backend\SiteMenu\FrontendMenu\FrontendMenuController@add')->name('frontend-menu.menu.add');
        Route::post('/menu/single/store', 'Backend\SiteMenu\FrontendMenu\FrontendMenuController@singleStore')->name('frontend-menu.menu.single.store');
        Route::post('/menu/store', 'Backend\SiteMenu\FrontendMenu\FrontendMenuController@store')->name('frontend-menu.menu.store');
        Route::get('/menu/edit/{id}', 'Backend\SiteMenu\FrontendMenu\FrontendMenuController@edit')->name('frontend-menu.menu.edit');
        Route::post('/menu/update/{id}', 'Backend\SiteMenu\FrontendMenu\FrontendMenuController@update')->name('frontend-menu.menu.update');
        Route::get('/menu/delete', 'Backend\SiteMenu\FrontendMenu\FrontendMenuController@destroy')->name('frontend-menu.menu.destroy');
    });

    Route::prefix('site_setting')->group(function () {
        //Slider
        Route::get('slider/{slider_master_id}', 'Backend\SiteSetting\Slider\SliderController@index')->name('site-setting.slider')->where('slider_master_id', '[0-9]+');
        Route::get('slider/add/{slider_master_id}', 'Backend\SiteSetting\Slider\SliderController@addSlider')->name('site-setting.slider.add');
        Route::post('slider/store', 'Backend\SiteSetting\Slider\SliderController@storeSlider')->name('site-setting.slider.store');
        Route::get('slider/edit/{slider_master_id}/{id}', 'Backend\SiteSetting\Slider\SliderController@editSlider')->name('site-setting.slider.edit');
        Route::post('slider/update/{id}', 'Backend\SiteSetting\Slider\SliderController@updateSlider')->name('site-setting.slider.update');
        Route::post('slider/delete', 'Backend\SiteSetting\Slider\SliderController@deleteSlider')->name('site-setting.slider.delete');
        //Slider Video
        Route::post('slider/store/video', 'Backend\SiteSetting\Slider\SliderController@storeSliderVideo')->name('site-setting.slider.store_video');

        //Slider Master
        Route::get('slider-master', 'Backend\SiteSetting\Slider\SliderMasterController@index')->name('site-setting.slider-master');
        Route::get('slider-master/add', 'Backend\SiteSetting\Slider\SliderMasterController@add')->name('site-setting.slider-master.add');
        Route::post('slider-master/store', 'Backend\SiteSetting\Slider\SliderMasterController@store')->name('site-setting.slider-master.store');
        Route::get('slider-master/edit/{id}', 'Backend\SiteSetting\Slider\SliderMasterController@edit')->name('site-setting.slider-master.edit');
        Route::post('slider-master/update/{id}', 'Backend\SiteSetting\Slider\SliderMasterController@update')->name('site-setting.slider-master.update');
        Route::post('slider-master/delete', 'Backend\SiteSetting\Slider\SliderMasterController@delete')->name('site-setting.slider-master.delete');

        //FAQ
        Route::get('/faq', 'Backend\SiteSetting\FAQ\FAQController@index')->name('site-setting.faq');
        Route::get('/faq/add', 'Backend\SiteSetting\FAQ\FAQController@Add')->name('site-setting.faq.add');
        Route::post('/faq/store', 'Backend\SiteSetting\FAQ\FAQController@Store')->name('site-setting.faq.store');
        Route::get('/faq/edit/{id}', 'Backend\SiteSetting\FAQ\FAQController@Edit')->name('site-setting.faq.edit');
        Route::post('/faq/update/{id}', 'Backend\SiteSetting\FAQ\FAQController@Update')->name('site-setting.faq.update');
        Route::post('/faq/delete', 'Backend\SiteSetting\FAQ\FAQController@Delete')->name('site-setting.faq.delete');
    });

    //});
});
// });
