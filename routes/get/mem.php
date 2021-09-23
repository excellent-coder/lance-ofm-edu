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
    Route::get('/', 'MemberController@license')->name('mem.licenses');

    Route::get('purchase/{slug}', 'LicensePaymentController@create')->name('mem.license.purchase');
    Route::post('purchase/{licence}', 'LicensePaymentController@store');
});

Route::get('license/paid/{payment}', 'LicensePaymentController@paid')->name('license.paid');
