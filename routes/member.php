<?php
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::name('profile-management.')->prefix('profile-management')->namespace('ProfileManagement')->group(base_path('routes/member/profile_management.php'));
