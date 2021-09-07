<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'StudentController@portal')->name('portal.dashboard');
Route::get('course/{slug}', 'StudentController@course')->name('portal.course');
Route::get('lesson/{slug}', 'StudentController@lesson')->name('portal.lesson');
