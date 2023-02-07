<?php

use Illuminate\Support\Facades\Route;
use App\Models\Resolution;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('users')->controller('App\Http\Controllers\UserController')->group(function(){
    Route::get('users','index')->name('users');
    Route::post('send-notification','sendNotification')->name('send-notification');
    Route::post('save-token','saveToken')->name('save-token');
    Route::get('images','images');
    Route::get('image-upload','createForm')->name('image-upload');
    Route::post('imageUpload','fileUpload')->name('imageUpload');
});

Route::prefix('log')->controller('App\Http\Controllers\LogController')->group(function(){
    Route::get('/','index');
});

Route::prefix('resolution')->controller('App\Http\Controllers\ResolutionController')->group(function(){
    Route::get('/','index')->name('resolution.list');
    Route::get('create','create')->name('resolution.create');
    Route::post('store','store')->name('resolution.store');
    Route::get('getSolution','getSolution')->name('getSolution');
});