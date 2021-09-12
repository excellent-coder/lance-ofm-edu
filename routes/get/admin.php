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
    Route::get('students', 'StudentRequestController@index')->name('.students');
    Route::get('details/{app}', 'ApplicationController@details')->name('.details');
    Route::get('{category}', 'ApplicationController@category')->name('.category');
    /**
     * Get matric number or member id of the next applicant to be approved
     */
    Route::get('id/{member}', 'ApplicationController@id')->name('.id');
    Route::get('approve/{type}/{item}', 'ApplicationController@approve')->name('.approve');
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
    Route::get('{slug}', 'MembershipController@members')->name('.members');
});


Route::prefix('licences')->name('licences')->group(function () {
    Route::get('/', 'LicenceController@index');
    Route::get('create', 'LicenceController@create')->name('.create');
    Route::get('edit/{licence}', 'LicenceController@edit')->name('.edit');

    Route::get('{slug}', 'LicenceController@members')->name('.members');

    Route::get('json/{program}/{level}', 'LicenceController@pl')->name('.pl.json');
});


Route::prefix('events')->name('events')->group(function () {
    Route::get('/', 'EventController@index');
    Route::get('create', 'EventController@create')->name('.create');
    Route::get('edit/{event}', 'EventController@edit')->name('.edit');
    Route::get('categories', 'EventCatController@index')->name('.categories');
});

Route::prefix('notifications')->name('notifications')->group(function () {
    Route::get('/', 'NotificationController@index');
    Route::get('create', 'NotificationController@create')->name('.create');
    Route::get('edit/{notice}', 'NotificationController@edit')->name('.edit');
    Route::get('categories', 'NotificationCatController@index')->name('.categories');

    Route::get('{slug}', 'NotificationController@show')->name('.show');
});

Route::prefix('members')->name('members')->group(function () {
    Route::get('/', 'MemberController@index');
    Route::get('create', 'MemberController@create')->name('.create');
    Route::get('edit/{event}', 'MemberController@edit')->name('.edit');
    Route::get('categories', 'MemberCatController@index')->name('.categories');
});
Route::prefix('students')->name('students')->group(function () {
    Route::get('/', 'StudentController@index');

    Route::get('approved', 'StudentRequestController@approved')->name('.approved');
    Route::get('pending', 'StudentRequestController@pending')->name('.pending');

    Route::get('paymnets', 'StudentPaymentController@index')->name('.payments');
    Route::get('payments/{student}', 'StudentPaymentController@student')
        ->name('.payment.student');

    Route::get('create', 'StudentController@create')->name('.create');
    Route::get('edit/{event}', 'StudentController@edit')->name('.edit');
    Route::get('categories', 'StudentCatController@index')->name('.categories');
});
Route::prefix('scs')->name('scs')->group(function () {
    Route::get('/', 'SCStudentController@index');
    Route::get('create', 'SCStudentController@create')->name('.create');
    Route::get('edit/{event}', 'SCStudentController@edit')->name('.edit');
    Route::get('categories', 'SCStudentCatController@index')->name('.categories');

    Route::get('{student}', 'SCStudentController@show')->name('.show');

    Route::get('programs/{app}', 'ScsProgramController@show')->name('.app');
});

Route::prefix('journals')->name('journals')->group(function () {
    Route::get('/', 'JournalController@index');
    Route::get('create', 'JournalController@create')->name('.create');
    Route::get('edit/{event}', 'JournalController@edit')->name('.edit');
    Route::get('categories', 'JournalCatController@index')->name('.categories');
});

Route::prefix('profile')->name('profile')->group(function () {
    Route::get('/', 'AdminProfileController@index');
    Route::get('edit', 'AdminProfileController@edit')->name('.edit');
});
