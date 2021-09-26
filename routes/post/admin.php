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
    Route::post('sstudent/{student}', 'StudentRequestController@approve')->name('.student.approve');
    Route::post('update/{app}', 'ApplicationController@update')->name('.update');
    Route::delete('destroy', 'ApplicationController@destroy')->name('.destroy');
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

Route::prefix('publocations')->name('pubs')->group(function () {
    Route::post('store', 'PublicationController@store')->name('.store');
    Route::delete('destroy', 'PublicationController@destroy')->name('.destroy');
    Route::post('update/{publication}', 'PublicationController@update')->name('.update');
});

Route::prefix('publication-cats')->name('pub-cats')->group(function () {
    Route::post('store', 'PublicationCatController@store')->name('.store');
    Route::delete('destroy', 'PublicationCatController@destroy')->name('.destroy');
    Route::post('update/{cat}', 'PublicationCatController@update')->name('.update');
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


Route::prefix('licences')->name('licences')->group(function () {
    Route::post('store', 'LicenceController@store')->name('.store');
    Route::post('update/{licence}', 'LicenceController@update')->name('.update');
    Route::delete('destroy', 'LicenceController@destroy')->name('.destroy');
    Route::post('activate/{post}', 'LicenceController@activate')->name('.activate');
});

Route::prefix('events')->name('events')->group(function () {
    Route::post('store', 'EventController@store')->name('.store');
    Route::post('update/{event}', 'EventController@update')->name('.update');
    Route::delete('destroy', 'EventController@destroy')->name('.destroy');
    Route::post('activate/{post}', 'EventController@activate')->name('.activate');
});


Route::prefix('event-cats')->name('event-cats')->group(function () {
    Route::post('store', 'EventCatController@store')->name('.store');
    Route::delete('destroy', 'EventCatController@destroy')->name('.destroy');
    Route::post('activate/{cat}', 'EventCatController@activate')->name('.activate');
    Route::post('update/{cat}', 'EventCatController@update')->name('.update');
});

Route::prefix('notifications')->name('notifications')->group(function () {
    Route::post('store', 'NotificationController@store')->name('.store');
    Route::delete('destroy', 'NotificationController@destroy')->name('.destroy');
    Route::post('activate/{notice}', 'NotificationController@activate')->name('.activate');
    Route::post('update/{cat}', 'NotificationController@update')->name('.update');

    Route::post('reply/{notice}/{model}', 'NotificationReplyController@store')->name('.reply');
});

Route::prefix('notification-cats')->name('notification-cats')->group(function () {
    Route::post('store', 'NotificationCatController@store')->name('.store');
    Route::delete('destroy', 'NotificationCatController@destroy')->name('.destroy');
    Route::post('activate/{cat}', 'NotificationCatController@activate')->name('.activate');
    Route::post('update/{cat}', 'NotificationCatController@update')->name('.update');
});

Route::prefix('members')->name('members')->group(function () {
    Route::post('store', 'MemberController@store')->name('.store');
    Route::post('update/{event}', 'MemberController@update')->name('.update');
    Route::delete('destroy', 'MemberController@destroy')->name('.destroy');
    Route::post('activate/{post}', 'MemberController@activate')->name('.activate');
});

Route::prefix('member-r')->name('member-r')->group(function () {
    Route::post('approve/{member}', 'MemberRequestController@approve')->name('.approve');

    Route::delete('destroy', 'MemberRequestController@destroy')->name('.destroy');
    // Route::post('activate/{post}', 'MemberRequestController@activate')->name('.activate');
});

Route::prefix('students')->name('students')->group(function () {
    Route::post('store', 'StudentController@store')->name('.store');
    Route::post('update/{event}', 'StudentController@update')->name('.update');
    Route::delete('destroy', 'StudentController@destroy')->name('.destroy');
    Route::post('activate/{post}', 'StudentController@activate')->name('.activate');
});

Route::prefix('student-r')->name('student-r')->group(function () {
    Route::post('approve/{student}', 'StudentRequestController@approve')->name('.approve');
    Route::delete('destroy', 'StudentRequestController@destroy')->name('.destroy');
    // Route::post('activate/{post}', 'StudentController@activate')->name('.activate');
});

Route::prefix('scs')->name('scs')->group(function () {
    Route::post('store', 'SCStudentController@store')->name('.store');
    Route::post('update/{student}', 'SCStudentController@update')->name('.update');
    Route::delete('destroy', 'SCStudentController@destroy')->name('.destroy');
    Route::post('activate/{student}', 'SCStudentController@activate')->name('.activate');

    Route::post('program/{app}', 'ScsProgramController@update')->name('.program.approve');
});

Route::prefix('journals')->name('journals')->group(function () {
    Route::post('store', 'JournalController@store')->name('.store');
    Route::post('update/{event}', 'JournalController@update')->name('.update');
    Route::delete('destroy', 'JournalController@destroy')->name('.destroy');
    Route::post('activate/{post}', 'JournalController@activate')->name('.activate');
});

Route::prefix('profile')->name('profile')->group(function () {
    Route::post('update', 'AdminProfileController@update')->name('.update');
});
