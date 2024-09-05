<?php

use App\Http\Controllers\SSOController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('sso/login', [SSOController::class, 'getLogin'])->name('sso.login');
Route::get('sso/auth/callback', [SSOController::class, 'getCallback'])->name('sso.callback');
Route::get('sso/connect', [SSOController::class, 'connectUser'])->name('sso.connect');

Route::permanentRedirect('/', '/login');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => ['web', 'auth', 'verified']], function () {
    Route::get('/home', function () {
        return view('home');
    });
});

