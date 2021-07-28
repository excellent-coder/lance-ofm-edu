<?php

use Illuminate\Support\Facades\Route;

// upload images via tinymce
Route::any('tinymce', 'AdminController@tinymce')->name('tinymce');

Route::prefix('pages')->name('pages')->group(function () {
    Route::post('store', 'PageController@store')->name('.store');
    Route::post('update/{page}', 'PageController@update')->name('.update');
});

Route::prefix('user-categories')->name('user-categories')->group(function () {
    Route::post('store', 'UserCategoryController@store')->name('.store');
    Route::delete('destroy', 'UserCategoryController@destroy')->name('.destroy');
    Route::post('update/{category}', 'UserCategoryController@update')->name('.update');
});

Route::prefix('applications')->name('applications')->group(function () {
    Route::post('approve/{app}', 'ApplicationController@approve')->name('.approve');
    Route::post('update/{application}', 'ApplicationController@update')->name('.update');
    Route::delete('destroy', 'ApplicationController@destroy')->name('.destroy');
});

Route::prefix('subjects')->name('subjects')->group(function () {
    Route::post('store', 'SubjectController@store')->name('.store');
    Route::post('update/{subject}', 'SubjectController@update')->name('.update');
    Route::delete('destroy', 'SubjectController@destroy')->name('.destroy');
});

Route::prefix('sessions')->name('sessions')->group(function () {
    Route::post('store', 'SessionController@store')->name('.store');
    Route::post('update/{session}', 'SessionController@update')->name('.update');
    Route::delete('destroy', 'SessionController@destroy')->name('.destroy');
    Route::post('activate/{session}/{admin?}', 'SessionController@activate')->name('.activate');
});

Route::prefix('lessons')->name('lessons')->group(function () {
    Route::delete('destroy', 'LessonController@destroy')->name('.destroy');
    Route::post('update/{lesson}', 'LessonController@update')->name('.update');
    Route::post('store', 'LessonController@store')->name('.store');
    Route::post('activate/{lesson}', 'LessonController@activate')->name('.activate');
});

Route::prefix('materials')->name('materials')->group(function () {
    Route::post('store', 'MaterialController@store')->name('.store');
    Route::delete('destroy', 'MaterialController@destroy')->name('.destroy');
    Route::post('activate/{material}', 'MaterialController@activate')->name('.activate');
});

Route::prefix('products')->name('products')->group(function () {
    Route::post('store', 'ProductController@store')->name('.store');
    Route::delete('destroy', 'ProductController@destroy')->name('.destroy');
    Route::post('activate/{product}', 'ProductController@activate')->name('.activate');
    Route::post('gallery', 'ProductController@gallery')->name('.gallery');
    Route::post('update/{product}', 'ProductController@update')->name('.update');
});

Route::prefix('product-cats')->name('product-cats')->group(function () {
    Route::post('store', 'ProductCatController@store')->name('.store');
    Route::delete('destroy', 'ProductCatController@destroy')->name('.destroy');
    Route::post('activate/{product}', 'ProductCatController@activate')->name('.activate');
    Route::post('product-cats/{cat}', 'ProductCatController@update')->name('.update');
});

Route::prefix('deliveries')->name('deliveries')->group(function () {
    Route::post('store', 'DeliveryMethodController@store')->name('.store');
    Route::delete('destroy', 'DeliveryMethodController@destroy')->name('.destroy');
    Route::post('activate/{method}', 'DeliveryMethodController@activate')->name('.activate');
    Route::post('deliveries/{method}', 'DeliveryMethodController@update')->name('.update');
});

Route::prefix('delivery-prices')->name('d-prices')->group(function () {
    Route::post('store', 'DeliveryPriceController@store')->name('.store');
    Route::delete('destroy', 'DeliveryPriceController@destroy')->name('.destroy');
    Route::post('activate/{price}', 'DeliveryPriceController@activate')->name('.activate');
    Route::post('deliveries/{price}', 'DeliveryPriceController@update')->name('.update');
});

Route::prefix('product-imgs')->name('product-imgs')->group(function () {
    Route::post('store', 'ProductCatController@store')->name('.store');
    Route::delete('destroy', 'ProductGalleryController@destroy')->name('.destroy');
    Route::post('activate/{img}', 'ProductGalleryController@activate')->name('.activate');
    Route::post('feature/{img}', 'ProductGalleryController@feature')->name('.feature');
    Route::post('product-cats/{cat}', 'ProductCatController@update')->name('.update');
});

Route::prefix('settings')->name('settings')->group(function () {
    Route::post('tag', 'SettingController@storetag')->name('.storetag');
    Route::delete('tag/destroy', 'SettingController@destroytag')->name('.destroytag');
    Route::post('tag/update/{tag}', 'SettingController@updatetag')->name('.updatetag');

    Route::post('store/{tag}', 'SettingController@store')->name('.store');
    Route::post('update/{tag}', 'SettingController@update')->name('.update');
});
