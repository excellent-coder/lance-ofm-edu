<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AdminController@dashboard')->name('dashboard');

Route::prefix('pages')->name('pages')->group(function () {
    Route::get('/', 'PageController@index');
    Route::get('create', 'PageController@create')->name('.create');
    Route::get('edit/{page}', 'PageController@edit')->name('.edit');
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


Route::prefix('publications')->name('pubs')->group(function () {
    Route::get('/', 'PublicationController@index');
    Route::get('create', 'PublicationController@create')->name('.create');
    Route::get('edit/{publication}', 'PublicationController@edit')->name('.edit');
    Route::get('categories', 'PublicationCatController@index')->name('.cats');
    Route::get('tags', 'TagController@index')->name('.tags');

    Route::get('{cat}', 'PublicationCatController@show')->name('.cat');
});

Route::prefix('Publication-cats')->name('Publication-cats')->group(function () {
    Route::get('children', 'PublicationCatController@children')->name('.children');
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
    Route::get('students/{level}', 'LevelController@students')->name('.students');
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

    Route::get('approved', 'MemberRequestController@approved')->name('.approved');
    Route::get('pending', 'MemberRequestController@pending')->name('.pending');

    Route::get('paymnets', 'MemberPaymentController@index')->name('.payments');

    Route::get('payments/{member}', 'MemberPaymentController@student')
        ->name('.payments.mem');


    Route::get('create', 'MemberController@create')->name('.create');
    Route::get('edit/{event}', 'MemberController@edit')->name('.edit');
    Route::get('categories', 'MemberCatController@index')->name('.categories');

    Route::get('{member}', 'MemberController@show')->name('.show');
});

Route::prefix('students')->name('students')->group(function () {
    Route::get('/', 'StudentController@index');

    Route::get('approved', 'StudentController@index')->name('.approved');
    Route::get('pending', 'StudentRequestController@pending')->name('.pending');

    Route::get('paymnets', 'StudentPaymentController@index')->name('.payments');

    Route::get('payments/{student}', 'StudentPaymentController@student')
        ->name('.payment.student');

    Route::get('create', 'StudentController@create')->name('.create');
    Route::get('edit/{event}', 'StudentController@edit')->name('.edit');
    Route::get('categories', 'StudentCatController@index')->name('.categories');

    Route::get('documents/{student}', 'StudentController@docs')->name('.docs');

    Route::get('graduated/{session?}', 'StudentController@graduated')->name('.graduated');

    Route::prefix('results')->group(function () {
        Route::get('/', 'StudentResultController@index')->name('.results');
        Route::get('sort/{year}', 'StudentResultController@index')->name('.results.year');
        Route::get('create', 'StudentResultController@create')->name('.results.create');
        Route::get('/edit/{result}', 'StudentResultController@edit')->name('.results.edit');
        Route::get('json', 'StudentResultController@json')->name('.results.json');
    });

    Route::get('grades', 'StudentActiveController@index')->name('.grades');
    Route::get('grades/edit/{student}', 'StudentActiveController@edit')->name('.grades.edit');


    // fees
    Route::prefix('fees')->group(function () {
        Route::get('/', 'StudentFeeController@index')->name('.fees');
    });
});

Route::prefix('scs')->name('scs')->group(function () {
    Route::get('/', 'ScsController@index');
    Route::get('create', 'SCStudentController@create')->name('.create');
    Route::get('edit/{event}', 'SCStudentController@edit')->name('.edit');
    Route::get('categories', 'SCStudentCatController@index')->name('.categories');

    Route::get('detail/{student}', 'ScsController@show')->name('.show');

    Route::get('programs/{app}', 'ScsProgramController@show')->name('.app');


    Route::get('sort/graduated', 'ScsController@graduated')->name('.graduated');
    Route::get('payments/pending', 'ScsPaymentController@pending')->name('.payments.pending');

    Route::prefix('results')->group(function () {
        Route::get('/', 'ScsResultController@index')->name('.results');
        Route::get('sort/{year}', 'ScsResultController@index')->name('.results.year');
        Route::get('create', 'ScsResultController@create')->name('.results.create');
    });
});

Route::prefix('scs-r')->group(function () {
    Route::get('json', 'ScsResultController@json')->name('scs-r.json');
});

Route::prefix('student-r')->group(function () {
    Route::get('json', 'StudentResultController@json')->name('student.json');
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

Route::prefix('exam-centers')->name('exam-c')->group(function () {
    Route::get('/', 'ExamCenterController@index');
});
