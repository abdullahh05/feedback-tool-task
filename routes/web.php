<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\FeedbackController;

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


Route::group(['middleware' => 'guest'], function (){
    Route::view('register', 'auth.register');
    Route::view('login', 'auth.login');
    Route::post('register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
});
Route::get('/', [FeedbackController::class, 'index'])->name('index');
Route::get('comments/{id}', [FeedbackController::class, 'comments']);


Route::group(['middleware' => 'auth'], function (){
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
    Route::post('feedback/store', [FeedbackController::class, 'store'])->name('feedback_store');
    Route::post('comment-store', [FeedbackController::class, 'commentStore']);
    Route::get('users-list', [FeedbackController::class, 'users']);
});
