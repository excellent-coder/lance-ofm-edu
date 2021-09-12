<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'StudentController@dashboard')->name('pgs');
Route::get('course/{slug}', 'StudentController@course')->name('pgs.course');
Route::get('lesson/{slug}', 'StudentController@lesson')->name('pgs.lesson');
