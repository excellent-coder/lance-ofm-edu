<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'SCStudentController@portal')->name('scs');


Route::prefix('program')->group(function () {
    Route::get('apply', 'SCStudentController@applyProgram')->name('scs.programs.apply');
    Route::post('apply', 'SCStudentController@updateProgram');
});

Route::get('program/{slug}', 'SCStudentController@program')->name('scs.program');

Route::get('courses/{course}', 'SCStudentController@course')->name('scs.course');
Route::get('lessons/{lesson}', 'SCStudentController@lesson')->name('scs.lesson');
