<?php

use Illuminate\Support\Facades\Route;

Route::prefix('payments')->group(function () {
    Route::get('scs/{payment}', 'ScsPaymentController@paid')->name('scs.paid');
    Route::get('student/{payment}', 'StudentPaymentController@paid')->name('pgs.paid');
    Route::get('member/{payment}', 'MemberPaymentController@paid')->name('mem.paid');

    // payment for application processing fee
    Route::get('entering/{payment}', 'AppPaymentController@paid')->name('app.paid');
});

Route::prefix('admin')->group(function () {
    Route::get('app/payment/{payment}', 'AppPaymentController@show')->name('app.payments.show');
    Route::get('scs/payment/{payment}', 'ScsPaymentController@show')->name('scs.payments.show');
});
