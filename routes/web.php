<?php

use Illuminate\Support\Facades\Route;

Route::get('storage-link',function(){
    \Artisan::call('storage:link');
});

Route::get('/', function () {
    // return view('frontend.home');
    return redirect()->route('admin.login');
});
// admin part
Route::get('admin/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('admin/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('admin/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('admin.logout');

Route::get('/admin/login-as-viewer', 'App\Http\Controllers\Auth\LoginController@loginAsViewer')->name('admin.login-as-viewer');

Route::get('admin/change-password', 'App\Http\Controllers\Auth\ChangePasswordController@changePassword')->name('admin.change-password');
Route::post('admin/change-password', 'App\Http\Controllers\Auth\ChangePasswordController@updatePassword')->name('admin.update-password')->middleware('checkUserRole');

Route::get('admin/password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin/password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('admin.password.update');

// member part
Route::get('member/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('member.login');
Route::post('member/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('member/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('member.logout');

Route::get('member/change-password', 'App\Http\Controllers\Auth\ChangePasswordController@changePassword')->name('member.change-password');
Route::post('member/change-password', 'App\Http\Controllers\Auth\ChangePasswordController@updatePassword')->name('member.update-password');

Route::get('member/password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('member.password.request');
Route::post('member/password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('member.password.email');
Route::get('member/password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('member.password.reset');
Route::post('member/password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('member.password.update');

// others
// Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');

// Route::get('password/confirm', 'App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
// Route::post('password/confirm', 'App\Http\Controllers\Auth\ConfirmPasswordController@confirm');

// Route::get('email/verify', 'App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
// Route::post('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');



