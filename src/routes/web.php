<?php

Route::group( ['namespace' => 'Mediusware\Affiliate\Http\Controllers', 'prefix'=>'affiliate'], function () {

    Route::get( 'test', 'AffiliateController@index' )->name('test');
    Route::post( 'test', 'AffiliateController@store' );
});
