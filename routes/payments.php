<?php

use Illuminate\Support\Facades\Route;

Route::prefix('payments')->group(function () {
    Route::get('student/induction/{student}', 'StudentPaymentController@induction')
        ->name('payment.pgs.induction');
    Route::post('student/induction/{student}', 'StudentPaymentController@storeInduction');
    Route::get('student/induction/paid/{payment}', 'StudentPaymentController@paidInduction')
        ->name('pgs.induction.paid');

    Route::get('scs/{payment}', 'ScsPaymentController@paid')->name('scs.paid');
    Route::get('student/{payment}', 'StudentPaymentController@paid')->name('pgs.paid');
    Route::get('member/{payment}', 'MemberPaymentController@paid')->name('mem.paid');

    // payment for application processing fee
    Route::get('entering/{payment}', 'AppPaymentController@paid')->name('app.paid');

    Route::get('member/induction/{member}', 'MemberPaymentController@induction')
        ->name('payment.mem.induction');
    Route::post('member/induction/{member}', 'MemberPaymentController@storeInduction');
    Route::get('member/induction/paid/{payment}', 'MemberPaymentController@paidInduction')
        ->name('mem.induction.paid');
});

Route::prefix('admin')->group(function () {
    Route::get('app/payment/{payment}', 'AppPaymentController@show')->name('app.payments.show');
    Route::get('scs/payment/{payment}', 'ScsPaymentController@show')->name('scs.payments.show');
});
