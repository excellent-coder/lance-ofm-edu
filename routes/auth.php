<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', 'AdminController@loginPage')->name('login');
    Route::post('login', 'AdminController@login');
    Route::get('password', 'AdminController@passwordPage')->name('password');
    Route::post('password', 'AdminController@password');
});


Route::any('logout', 'AuthController@logout')->name('logout');

Route::get('member/apply', 'MemberRequestController@create')->name('mem.apply');
Route::post('member/apply', 'MemberRequestController@store');

Route::get('member/appeal/{member}', 'MemberAppealController@create')->name('mem.appeal');
Route::post('member/appeal/{member}', 'MemberAppealController@store');

Route::get('json/memberships/{parent}', 'MembershipController@children');

Route::get('main-student/apply', 'StudentRequestController@create')->name('pgs.apply');
Route::post('main-student/apply', 'StudentRequestController@store');



Route::get('password', 'AuthController@passwordPage')->name('password');
Route::post('password', 'AuthController@password');

Route::middleware(['guest:scs', 'guest:pgs', 'guest:mem'])->group(function () {

    Route::get('scs/apply', 'ScsController@create')->name('scs.apply');
    Route::post('scs/apply', 'ScsController@store');

    Route::get('login', 'AuthController@loginPage')->name('login');
    Route::post('login', 'AuthController@login');

    Route::prefix('scs')->group(function () {
        Route::get('password', 'AuthController@passwordPage')->name('scs.password');
        Route::post('password', 'AuthController@password');
    });

    Route::prefix('main-student')->group(function () {
        Route::get('password', 'AuthController@passwordPage')->name('pgs.password');
        Route::post('password', 'AuthController@password');
    });

    Route::prefix('members')->group(function () {
        Route::get('password', 'AuthController@passwordPage')->name('mem.password');
        Route::post('password', 'AuthController@password');
    });
});
