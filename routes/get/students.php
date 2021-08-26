<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'StudentController@portal')->name('portal.dashboard');
