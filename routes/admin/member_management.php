<?php
// member
Route::prefix( 'member-info' )->name( 'member-info.' )->group( function () {
    Route::get( '/list', 'MemberController@list' )->name( 'list' );
    Route::get( '/sorting', 'MemberController@sorting' )->name( 'sorting' );
    Route::get( '/add', 'MemberController@add' )->name( 'add' );
    Route::get( '/duplicate-email-check', 'MemberController@duplicateEmailCheck' )->name( 'duplicate-email-check' );
    Route::get( '/duplicate-mobile_no-check', 'MemberController@duplicateMobileNoCheck' )->name( 'duplicate-mobile_no-check' );
    Route::post( '/store', 'MemberController@store' )->name( 'store' );
    Route::get( '/edit/{editData}', 'MemberController@edit' )->name( 'edit' );
    Route::post( '/update/{editData}', 'MemberController@update' )->name( 'update' );
    Route::post( '/destroy', 'MemberController@destroy' )->name( 'destroy' );
});
