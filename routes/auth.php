<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', 'AdminController@loginPage')->name('login');
    Route::post('login', 'AdminController@login');
    Route::get('password', 'AdminController@passwordPage')->name('password');
    Route::post('password', 'AdminController@password');
});


Route::any('logout', 'AuthController@logout')->name('logout');

Route::get('member/apply', 'ApplicationController@memberApply')->name('mem.apply');
Route::post('member/apply', 'ApplicationController@store');

Route::get('json/memberships/{parent}', 'MembershipController@children');

Route::get('main-student/apply', 'StudentRequestController@create')->name('pgs.apply');
Route::post('main-student/apply', 'StudentRequestController@store');



Route::post('password', 'AuthController@password')->name('password');

Route::middleware(['guest:scs', 'guest:pgs', 'guest:mem'])->group(function () {

    Route::get('scs/apply', 'SCStudentController@create')->name('scs.apply');
    Route::post('scs/apply', 'SCStudentController@apply');

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
