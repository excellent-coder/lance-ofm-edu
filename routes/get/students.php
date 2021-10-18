<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'StudentController@dashboard')->name('pgs');
Route::get('course/{slug}', 'StudentController@course')->name('pgs.course');
Route::get('lesson/{slug}', 'StudentController@lesson')->name('pgs.lesson');

Route::post('passport', 'StudentController@updatePassport')->name('pgs.passport');

// payment for next level
Route::get('tuition/pay', 'StudentActiveController@create')->name('pgs.tuition.pay');
Route::post('fee/pay/{fee}', 'StudentActiveController@payFee')->name('pgs.fee.pay');
Route::get('fee/paid/{payment}', 'StudentActiveController@PaidFee')->name('pgs.fee.paid');

Route::get('exam/register', 'StudentActiveController@exam')->name('pgs.exam.register');
Route::post('exam/register', 'StudentActiveController@examRegister');


Route::get('results', 'StudentResultController@pgs')->name('pgs.results');
