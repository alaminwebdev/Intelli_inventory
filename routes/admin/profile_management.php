<?php
// profile
Route::prefix( 'profile-info' )->name( 'profile-info.' )->group( function () {
    Route::get( '/profile', 'ProfileController@profile' )->name( 'profile' );
    Route::get( '/duplicate-email-check', 'ProfileController@duplicateEmailCheck' )->name( 'duplicate-email-check' );
    Route::get( '/duplicate-mobile_no-check', 'ProfileController@duplicateMobileNoCheck' )->name( 'duplicate-mobile_no-check' );
    Route::get( '/update', 'ProfileController@edit' )->name( 'update' );
    Route::post( '/update', 'ProfileController@update' )->name( 'update' )->middleware('checkUserRole');
});