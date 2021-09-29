<?php

use Illuminate\Support\Facades\Route;

/**
 * This route contains all route that are accessible to
 *  authenticated members members
 */

Route::get('/', 'MemberController@dashboard')->name('mem');
Route::get('profile', 'MemberProfileController@profile')->name('mem.profile');
Route::post('profile', 'MemberProfileController@updateProfile');


Route::prefix('licenses')->group(function () {
    Route::get('/', 'MemberController@license')->name('mem.license');

    Route::get('all', 'LicensePaymentController@all')->name('mem.license.all');
    Route::get('expeired', 'LicensePaymentController@expeired')->name('mem.license.expeired');
    Route::get('payments', 'LicensePaymentController@payments')->name('mem.license.payments');

    // Route::get('purchase/{slug}', 'LicensePaymentController@create')->name('mem.license.purchase');
    // Route::post('purchase/{licence}', 'LicensePaymentController@store');
    // Route::get('paid/{payment}', 'LicensePaymentController@paid')->name('license.paid');
});


Route::prefix('publications')->group(function () {
    Route::get('/', 'MemberController@publications')->name('mem.pubs');
    Route::get('{slug}', 'PublicationController@show')->name('mem.pubs.show');
    Route::get('download/{pub}', 'PublicationController@download')->name('mem.pubs.download');

    Route::post('purchase/{pub}', 'PublicationPurchaseController@store')->name('mem.pubs.purchase');
    Route::get('payment/{purchase}', 'PublicationPurchaseController@paid')->name('mem.pubs.paid');
    Route::get('premium-download/{purchase}', 'PublicationPurchaseController@download')->name('mem.pubs.paid-download');
});

Route::prefix('events')->group(function () {
    Route::get('/', 'MemberController@events')->name('mem.events');
    Route::get('register/{event}', 'EventController@register')->name('events.register');
    Route::post('register/{event}', 'EventGoerController@store');
    Route::get('paid/{payment}', 'MemberPaymentController@eventPaid')->name('mem.event.paid');
});

Route::prefix('bills')->group(function () {
    Route::get('/', 'MemberBillController@bills')->name('mem.bills');
    Route::get('payments', 'MemberBillController@payments')->name('mem.bills.payments');
    Route::get('paid', 'MemberBillController@paid')->name('mem.bills.paid');
    Route::get('pending', 'MemberBillController@pending')->name('mem.bills.pending');
});

Route::post('passport', 'MemberController@updatePassport')->name('mem.passport');
Route::post('pay/annual', 'MemberAnnualController@store')->name('mem.pay.annual');
