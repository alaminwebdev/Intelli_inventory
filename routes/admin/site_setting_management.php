<?php

Route::prefix('site-setting-info')->name('site-setting-info.')->group(function(){
	Route::get('/list','SiteSettingController@list')->name('list');
	Route::post('/update','SiteSettingController@update')->name('update');
});

Route::prefix('email-configuration-info')->name('email-configuration-info.')->group(function(){
	Route::get('/list','EmailConfigurationController@list')->name('list');
	Route::post('/update','EmailConfigurationController@update')->name('update');
});

Route::prefix('menu-info')->name('menu-info.')->group(function(){
	Route::get('/list', 'MenuController@list')->name('list');
	Route::get('/add', 'MenuController@add')->name('add');
	Route::post('/store', 'MenuController@store')->name('store');
	Route::get('/edit/{id}', 'MenuController@edit')->name('edit');
	Route::post('/update/{id}', 'MenuController@update')->name('update');
	Route::get('/get-sub-menu', 'MenuController@getSubMenu')->name('get-sub-menu');
});

Route::prefix('module-info')->name('module-info.')->group(function(){
	Route::get('/list','ModuleController@list')->name('list');
	Route::get('/sorting','ModuleController@sorting')->name('sorting');
	Route::get('/add','ModuleController@add')->name('add');
	Route::get('/duplicate-name-check','ModuleController@duplicateNameCheck')->name('duplicate-name-check');
	Route::post('/store','ModuleController@store')->name('store');
	Route::get('/edit/{editData}','ModuleController@edit')->name('edit');
	Route::post('/update/{editData}','ModuleController@update')->name('update');
	Route::post('/delete','ModuleController@destroy')->name('delete');
});
