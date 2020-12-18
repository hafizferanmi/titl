<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// TODO - Implement next and previous page

Route::get('/getDataBalance/{phoneNumber}', [App\Http\Controllers\USSDcontroller::class, 'getDataBalance']);
Route::get('/getPhoneNumber/{phoneNumber}', [App\Http\Controllers\USSDcontroller::class, 'getPhoneNumber']);
Route::get('/getWalletBalance/{phoneNumber}', [App\Http\Controllers\USSDcontroller::class, 'getWalletBalance']);
Route::post('/ussd', [App\Http\Controllers\USSDcontroller::class, 'ussd']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
