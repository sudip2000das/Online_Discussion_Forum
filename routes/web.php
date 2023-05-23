<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::group(['middleware' => 'guest'],function(){
    Route::get('login', [AuthController::class,'index'])->name('login'); 
    Route::get('register', [AuthController::class,'register_view'])->name('register'); 

    Route::post('register', [AuthController::class,'register'])->name('register'); 
    Route::post('login', [AuthController::class,'login'])->name('login'); 
    // Route::get('home', [AuthController::class,'home'])->name('home');
    Route::get('guest', [AuthController::class,'guest'])->name('guest');
    Route::post('guest', [AuthController::class,'guest'])->name('guest');
});


Route::group(['middleware' => 'auth'],function(){
    Route::get('home', [AuthController::class,'home'])->name('home'); 
    Route::get('logout', [AuthController::class,'logout'])->name('logout');
    Route::post('add_comment', [AuthController::class,'add_comment'])->name('add_comment'); 
    Route::post('add_replay', [AuthController::class,'add_replay'])->name('add_replay');
    Route::get('update/{user}', [AuthController::class,'update'])->name('update');
    Route::post('update/{user}', [AuthController::class,'update_profile'])->name('update');
    // Route::post('/update', 'UserController@update')->name('update');
    Route::get('best_replay/{comment_id}', [AuthController::class,'best_replay'])->name('best_replay');
});


