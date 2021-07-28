<?php

use Illuminate\Support\Facades\Route;



Route::prefix('shop')->group(function () {
    Route::get('/', 'ProductController@shop')->name('shop');
    Route::get('{slug}', 'ProductController@show')->name('shop.product');
    Route::get('category/{slug}', 'ProductCatController@show')->name('shop.cat.show');
});

Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/', 'PortalController@index')->name('index');
    Route::get('profile/status', 'ProfileController@status')->name('profile.status');
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');

    Route::get('application/{slug}', 'UserCategoryController@create')->name('application.create');

    Route::get('subjects/{slug}', 'SubjectController@show')->name('subjects');
    Route::get('lessons/{slug}', 'LessonController@show')->name('lessons');
});
