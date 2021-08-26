<?php

use Illuminate\Support\Facades\Route;

/**
 * This route contains all route that are accessible to
 *  authenticated members members
 */

Route::post('profile', 'MemberController@UpdateProfile');
