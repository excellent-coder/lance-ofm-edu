<?php

use Illuminate\Support\Facades\Route;

// upload images via tinymce
Route::any('tinymce', 'AdminController@tinymce')->name('tinymce');

Route::any('logout', 'AdminController@logout')->name('logout');

Route::prefix('pages')->name('pages')->group(function () {
    Route::post('store', 'PageController@store')->name('.store');
    Route::post('update/{page}', 'PageController@update')->name('.update');
    Route::delete('destroy', 'PageController@destroy')->name('.destroy');
    Route::post('publish/{page}', 'PageController@publish')->name('.publish');
});

Route::prefix('user-categories')->name('user-categories')->group(function () {
    Route::post('store', 'UserCategoryController@store')->name('.store');
    Route::delete('destroy', 'UserCategoryController@destroy')->name('.destroy');
    Route::post('update/{category}', 'UserCategoryController@update')->name('.update');
});

Route::prefix('applications')->name('applications')->group(function () {
    Route::post('approve/{app}', 'ApplicationController@approve')->name('.approve');
    Route::post('update/{app}', 'ApplicationController@update')->name('.update');
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

Route::prefix('posts')->name('posts')->group(function () {
    Route::post('store', 'PostController@store')->name('.store');
    Route::post('update/{post}', 'PostController@update')->name('.update');
    Route::delete('destroy', 'PostController@destroy')->name('.destroy');
    Route::post('activate/{post}', 'PostController@activate')->name('.activate');
});


Route::prefix('post-cats')->name('post-cats')->group(function () {
    Route::post('store', 'PostCatController@store')->name('.store');
    Route::delete('destroy', 'PostCatController@destroy')->name('.destroy');
    Route::post('activate/{cat}', 'PostCatController@activate')->name('.activate');
    Route::post('update/{cat}', 'PostCatController@update')->name('.update');
});

Route::prefix('tags')->name('tags')->group(function () {
    Route::post('store', 'TagController@store')->name('.store');
    Route::delete('destroy', 'TagController@destroy')->name('.destroy');
    Route::post('activate/{tag}', 'TagController@activate')->name('.activate');
    Route::post('update/{tag}', 'TagController@update')->name('.update');
});

Route::prefix('images')->name('images')->group(function () {
    Route::post('store', 'ImageController@store')->name('.store');
    Route::post('update/{image}', 'ImageController@update')->name('.update');
    Route::delete('destroy', 'ImageController@destroy')->name('.destroy');
    Route::post('activate/{image}', 'ImageController@activate')->name('.activate');

    Route::post('store-part', 'ImageController@storePart')->name('.store-parts');
});

Route::prefix('courses')->name('courses')->group(function () {
    Route::post('store', 'CourseController@store')->name('.store');
    Route::post('update/{course}', 'CourseController@update')->name('.update');
    Route::delete('destroy', 'CourseController@destroy')->name('.destroy');
    Route::post('activate/{post}', 'CourseController@activate')->name('.activate');
});

Route::prefix('programs')->name('programs')->group(function () {
    Route::post('store', 'ProgramController@store')->name('.store');
    Route::post('update/{program}', 'ProgramController@update')->name('.update');
    Route::delete('destroy', 'ProgramController@destroy')->name('.destroy');
    Route::post('activate/{post}', 'ProgramController@activate')->name('.activate');
});

Route::prefix('levels')->name('levels')->group(function () {
    Route::post('store', 'LevelController@store')->name('.store');
    Route::post('update/{level}', 'LevelController@update')->name('.update');
    Route::delete('destroy', 'LevelController@destroy')->name('.destroy');
    Route::post('activate/{post}', 'LevelController@activate')->name('.activate');
});

Route::prefix('memberships')->name('memberships')->group(function () {
    Route::post('store', 'MembershipController@store')->name('.store');
    Route::post('update/{membership}', 'MembershipController@update')->name('.update');
    Route::delete('destroy', 'MembershipController@destroy')->name('.destroy');
    Route::post('activate/{post}', 'MembershipController@activate')->name('.activate');
});
