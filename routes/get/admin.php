<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'AdminController@dashboard')->name('dashboard');

Route::prefix('pages')->name('pages')->group(function () {
    Route::get('/', 'PageController@index');
    Route::get('create', 'pageController@create')->name('.create');
    Route::get('edit/{page}', 'PageController@edit')->name('.edit');
});

Route::prefix('user-categories')->name('user-categories')->group(function () {
    Route::get('/', 'UserCategoryController@index');
});

Route::prefix('applications')->name('applications')->group(function () {
    Route::get('/', 'ApplicationController@index');
    Route::get('/{category}', 'ApplicationController@category')->name('.category');
});

Route::prefix('subjects')->name('subjects')->group(function () {
    Route::get('/', 'SubjectController@index');
});

Route::prefix('sessions')->name('sessions')->group(function () {
    Route::get('/', 'SessionController@index');
});

Route::prefix('lessons')->name('lessons')->group(function () {
    Route::get('/', 'LessonController@index');
    Route::get('create', 'LessonController@create')->name('.create');
    Route::get('edit/{lesson}', 'LessonController@edit')->name('.edit');
});

Route::prefix('products')->name('products')->group(function () {
    Route::get('/', "ProductController@index");
    Route::get('create', 'ProductController@create')->name('.create');
    Route::get('edit/{product}', 'ProductController@edit')->name('.edit');
    Route::get('categories', 'ProductCatController@index')->name('.categories');
    Route::get('deliveries', 'DeliveryMethodController@index')->name('.deliveries');
    Route::get('delivery-prices', 'DeliveryPriceController@index')->name('.d-prices');
});

Route::prefix('product-cats')->name('product-cats')->group(function () {
    Route::get('/children', 'ProductCatController@children')->name('.children');
});

Route::prefix('settings')->name('settings')->group(function () {
    Route::get('/', 'SettingController@index');
    Route::get('/{slug}', 'SettingController@tag')->name('.edit');
});
