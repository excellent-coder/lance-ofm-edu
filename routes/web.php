<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// $user = new User();
// $user->name = 'Emmanuel David';
// $user->email = 'info@worldtok.com';
// $user->password = bcrypt('password');
// $user->admin = 1;
// $user->save();
// $user = User::find(1);
// Auth::login($user);



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('l', function () {
    foreach (['pgs', 'scs', 'mem'] as $g) {
        if ($a = auth($g)->user()) {
            return [$g, $a];
        }
    }
});

Route::get('/psw', function () {
    return password_hash('ofemco', PASSWORD_BCRYPT);
});

Route::get('/', 'HomeController@home')->name('home');
require __DIR__ . '/auth.php';

Route::get('/pages/{slug}', 'PageController@show')->name('page.show');
Route::get('/auction/{slug}', 'AuctionController@show')->name('auction.show');

require __DIR__ . '/get/app.php';

Route::middleware(['auth'])->group(function () {
    require __DIR__ . '/post/app.php';
});

Route::get('dashboard', 'FrontendController@dashboard')->name('dashboard');

// register admin routes
Route::middleware(['ceo'])->prefix('admin')->name('admin.')->group(function () {
    require __DIR__ . '/get/admin.php';
    require __DIR__ . '/post/admin.php';
});

Route::prefix('scs')->middleware('auth:scs')->group(function () {
    require __DIR__ . '/get/scs.php';
});


Route::get('verify/member/{id}/{email}', 'MemberRequestController@verifyEmail')
    ->name('mem.verify');

Route::get('member/{member}/add-password', 'MemberController@addPassword')
    ->name('mem.add-password');
Route::post('member/{member}/add-password', 'MemberController@storePassword');
Route::prefix('member')->middleware('auth:mem')->group(function () {
    require __DIR__ . '/get/mem.php';
});

Route::get('/verify/ms/{id}/{email}', 'StudentRequestController@verifyEmail')->name('pgs.verify');

Route::get('student/{student}/add-password', 'StudentController@addPassword')
    ->name('pgs.add-password');
Route::post('student/{student}/add-password', 'StudentController@storePassword');
Route::prefix('student')->middleware('auth:pgs')->group(function () {
    require __DIR__ . '/get/students.php';
});



Route::get('login-ceo', function () {
    return view('auth.login');
});

require __DIR__ . '/payments.php';
require __DIR__ . '/email.php';
Route::post('ceo-login', 'AdminController@ceo');
