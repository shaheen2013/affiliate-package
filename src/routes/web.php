<?php

Route::group( ['namespace' => 'Mediusware\Affiliate\Http\Controllers', 'prefix'=>'affiliate', 'middleware' => 'web'], function () {
    Route::get( '/', 'AffiliateController@index' )->name('affiliate.form');
    Route::post( '/store', 'AffiliateController@store' )->name('affiliate.store');

    Route::group(['middleware' => ['auth','verified']], function () {
        Route::get( '/dashboard', 'AffiliateController@dashboard' );
        Route::get( '/banner', 'AffiliateController@banner' );
        Route::post( '/payment-store', 'AffiliateController@paymentStore' )->name('affiliate.payment.store');
        Route::post( '/banner-store', 'AffiliateController@bannerStore' )->name('affiliate.banner.store');
    });
});

Route::group(['namespace' => 'Mediusware\Affiliate\Http\Controllers', 'prefix' => 'admin', 'middleware' => ['web','admin','role:super-admin,admin']], function () {
    Route::get( '/affiliate', 'AdminController@index' );
    Route::get( '/affiliate/{id}', 'AdminController@show' );
    Route::get( '/affiliate/all', 'AdminController@allAffiliate' );
    Route::get( '/affiliate/pending', 'AdminController@pendingAffiliate' );
    Route::get( '/affiliate/approved', 'AdminController@approvedAffiliate' );
    Route::get( '/affiliate/rejected', 'AdminController@rejectedAffiliate' );
    Route::post( '/affiliate/{id}/delete', 'AdminController@deleteAffiliate' );
    Route::post( '/affiliate/{id}/{status}', 'AdminController@statusAffiliate' );

    Route::get( '/affiliate-dashboard', 'AdminController@dashboard' );

    Route::get( '/affiliate-banner', 'AdminController@banner' );
    Route::get( '/affiliate-banner/{id}/edit', 'AdminController@banner' );
    Route::post( '/affiliate-banner/store', 'AdminController@bannerPost' );
    Route::post( '/affiliate-banner/{id}/delete', 'AdminController@bannerDestroy' );
});
