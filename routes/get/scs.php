<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'ScsController@dashboard')->name('scs');


Route::prefix('program')->group(function () {
    Route::get('apply', 'ScsController@applyProgram')->name('scs.programs.apply');
    Route::post('apply/{program}', 'ScsController@updateProgram')->name('scs.program.apply');
});

Route::get('program/{slug}', 'SCStudentController@program')->name('scs.program');

Route::get('courses/{course}', 'SCStudentController@course')->name('scs.course');
Route::get('lessons/{lesson}', 'SCStudentController@lesson')->name('scs.lesson');

Route::get('results', 'ScsResultController@scs')->name('scs.results');
