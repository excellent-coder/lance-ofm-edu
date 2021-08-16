<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AdminController@dashboard')->name('dashboard');

Route::prefix('pages')->name('pages')->group(function () {
    Route::get('/', 'PageController@index');
    Route::get('create', 'PageController@create')->name('.create');
    Route::get('edit/{page}', 'PageController@edit')->name('.edit');
});

Route::prefix('user-categories')->name('user-categories')->group(function () {
    Route::get('/', 'UserCategoryController@index');
});

Route::prefix('applications')->name('applications')->group(function () {
    Route::get('/', 'ApplicationController@index');
    Route::get('details/{app}', 'ApplicationController@details')->name('.details');
    Route::get('/{category}', 'ApplicationController@category')->name('.category');
    Route::get('id/{member}', 'ApplicationController@id')->name('.id');
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

Route::prefix('posts')->name('posts')->group(function () {
    Route::get('/', 'PostController@index');
    Route::get('create', 'PostController@create')->name('.create');
    Route::get('edit/{post}', 'PostController@edit')->name('.edit');
    Route::get('categories', 'PostCatController@index')->name('.categories');
    Route::get('tags', 'TagController@index')->name('.tags');
});

Route::prefix('post-cats')->name('post-cats')->group(function () {
    Route::get('children', 'PostCatController@children')->name('.children');
});

Route::prefix('images')->name('images')->group(function () {
    Route::get('/', 'ImageController@index');
    Route::get('edit/{image}', 'ImageController@edit')->name('.edit');
    Route::get('{part}', 'ImageController@part')->name('.part');
});


Route::prefix('courses')->name('courses')->group(function () {
    Route::get('/', 'CourseController@index');
    Route::get('create', 'CourseController@create')->name('.create');
    Route::get('edit/{course}', 'CourseController@edit')->name('.edit');

    Route::get('{slug}/program', 'CourseController@program')->name('.program');

    Route::get('json/{program}/{level}', 'CourseController@pl')->name('.pl.json');
});

Route::prefix('programs')->name('programs')->group(function () {
    Route::get('/', 'ProgramController@index');
    Route::get('create', 'ProgramController@create')->name('.create');
    Route::get('edit/{program}', 'ProgramController@edit')->name('.edit');
});

Route::prefix('levels')->name('levels')->group(function () {
    Route::get('/', 'LevelController@index');
});

Route::prefix('memberships')->name('memberships')->group(function () {
    Route::get('/', 'MembershipController@index');
    Route::get('{members}', 'MembershipController@members')->name('.members');
});
