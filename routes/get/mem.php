<?php

use Illuminate\Support\Facades\Route;

/**
 * This route contains all route that are accessible to
 *  authenticated members members
 */

Route::get('/', 'MemberController@portal')->name('mem.dashboard');
Route::get('profile', 'MemberController@profile')->name('mem.profile');
