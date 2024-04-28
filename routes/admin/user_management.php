<?php
// user
Route::prefix( 'user-info' )->name( 'user-info.' )->group( function () {
    Route::get( '/list', 'UserController@list' )->name( 'list' );
    Route::get( '/sorting', 'UserController@sorting' )->name( 'sorting' );
    Route::get( '/add', 'UserController@add' )->name( 'add' );
    Route::get( '/duplicate-email-check', 'UserController@duplicateEmailCheck' )->name( 'duplicate-email-check' );
    Route::get( '/duplicate-mobile_no-check', 'UserController@duplicateMobileNoCheck' )->name( 'duplicate-mobile_no-check' );
    Route::post( '/store', 'UserController@store' )->name( 'store' )->middleware('checkUserRole');
    Route::get( '/edit/{editData}', 'UserController@edit' )->name( 'edit' );
    Route::post( '/update/{editData}', 'UserController@update' )->name( 'update' )->middleware('checkUserRole');
    Route::post( '/destroy', 'UserController@destroy' )->name( 'destroy' )->middleware('checkUserRole');
});
