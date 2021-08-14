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

Route::name('static-pages')->group(function () {
    Route::get('awards', 'PageController@static')->name('.awards');
    Route::get('journals', 'PageController@static')->name('.journals');
    Route::get('about', 'PageController@static')->name('.about');

    Route::get('donate', 'PageController@static')->name('.donate');
    Route::get('contact', 'PageController@static')->name('.contact');

    Route::prefix('memberships')->name('.memberships')->group(function () {
        Route::get('student', 'StaticPageController@memberships')->name('.student');
        Route::get('associate', 'StaticPageController@memberships')->name('.associate');
        Route::get('direct', 'StaticPageController@memberships')->name('.direct');
        Route::get('honourary', 'StaticPageController@memberships')->name('.honourary');
    });

    Route::prefix('licences')->name('.licences')->group(function () {
        Route::get('administrator', 'StaticPageController@licences')->name('.admin');
        Route::get('manager', 'StaticPageController@licences')->name('.manager');
        Route::get('consultant', 'StaticPageController@licences')->name('.consult');
        Route::get('supplier', 'StaticPageController@licences')->name('.supplier');
        Route::get('teacher', 'StaticPageController@licences')->name('.teacher');
    });
});

Route::get('programs/{slug}', 'ProgramController@show')->name('programs.show');

Route::prefix('blog')->group(function () {
    Route::get('{slug}', 'PostController@show')->name('posts.show');
    Route::get('order/latest', 'PostCatController@latest')->name('posts.latest');
    Route::get('category/{slug}', 'PostCatController@show')->name('post-cats.show');
    Route::get('tags/{tag}', 'TagController@show')->name('tags.show');
});

Route::get('pages/{slug}', 'PageController@show')->name('pages.show');
