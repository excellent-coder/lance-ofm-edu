<?php

use Illuminate\Support\Facades\Route;

Route::post('signup', 'AuthController@signup')->middleware('guest');
Route::post('login', 'AuthController@login')->middleware('guest');
Route::post('reset', 'AuthController@reset')->middleware('guest');

Route::get('{authPage}', 'AuthController@page')
    ->where('authPage', '(login|register|signup|password|reset-password|sign-up)')
    ->name('login');
// $router->pattern('id', '[0-9]+')


Route::any('logout', 'AuthController@logout')->middleware('auth');
Route::get('admin/login', 'AdminController@login')->name('admin.login');
