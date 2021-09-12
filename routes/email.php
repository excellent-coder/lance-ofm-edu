<?php

use Illuminate\Support\Facades\Route;

Route::get('email/pgs/induction/{student}', 'StudentPaymentController@test');
