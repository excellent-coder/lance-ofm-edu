<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', 'AdminController@loginPage')->name('login');
    Route::post('login', 'AdminController@login');
    Route::get('password', 'AdminController@passwordPage')->name('password');
    Route::post('password', 'AdminController@password');
});


Route::get('apply', 'ApplicationController@create')->name('apply');


Route::any('logout', 'AuthController@logout')->name('logout');

Route::post('signup', 'AuthController@signup')->middleware('guest');
Route::post('reset', 'AuthController@reset')->middleware('guest');

Route::middleware('guest:scs')->group(function () {
    Route::get('register', 'AuthController@registerPage')->name('register');
    Route::post('register', 'AuthController@register');

    Route::get('login', 'AuthController@loginPage')->name('login');
    Route::post('login', 'AuthController@login');

    Route::get('password', 'AuthController@passwordPage')->name('password');
    Route::post('password', 'AuthController@password');
});
