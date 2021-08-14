<?php

use Illuminate\Support\Facades\Route;

Route::prefix('portal')->name('portal.')->group(function () {
    Route::post('profile/update', 'ProfileController@update')->name('profile.update');
    Route::post('applications', 'ApplicationController@store')->name('applications.store');
});

Route::post('contact', 'ContactController@store')->name('contact.store');
