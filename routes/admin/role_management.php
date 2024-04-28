<?php
// role
Route::prefix( 'role-info' )->name( 'role-info.' )->group( function () {
    Route::get( '/list', 'RoleController@list' )->name( 'list' );
    Route::get( '/sorting', 'RoleController@sorting' )->name( 'sorting' );
    Route::get( '/add', 'RoleController@add' )->name( 'add' );
    Route::get( '/duplicate-name-check', 'RoleController@duplicateNameCheck' )->name( 'duplicate-name-check' );
    Route::post( '/store', 'RoleController@store' )->name( 'store' )->middleware('checkUserRole');
    Route::get( '/edit/{editData}', 'RoleController@edit' )->name( 'edit' );
    Route::post( '/update/{editData}', 'RoleController@update' )->name( 'update' )->middleware('checkUserRole');
    Route::post( '/destroy', 'RoleController@destroy' )->name( 'destroy' )->middleware('checkUserRole');
} );

// menu-permission
Route::prefix( 'role-permission-info' )->name( 'role-permission-info.' )->group( function () {
    Route::get( '/list', 'RolePermissionController@list' )->name( 'list' );
    Route::post( '/store', 'RolePermissionController@store' )->name( 'store' )->middleware('checkUserRole');
} );