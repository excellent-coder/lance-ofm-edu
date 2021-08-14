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

// register admin routes
Route::middleware(['ceo'])->prefix('admin')->name('admin.')->group(function () {
    require __DIR__ . '/get/admin.php';
    require __DIR__ . '/post/admin.php';
});

Route::prefix('scs')->middleware('auth:scs')->group(function () {
    require __DIR__ . '/get/scs.php';
});



Route::get('login-ceo', function () {
    return view('auth.login');
});

Route::post('ceo-login', 'AdminController@ceo');
