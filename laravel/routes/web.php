<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/usuarios', [UserController::class, 'create'])->name('user.create');
Route::post('/usuarios', [UserController::class, 'register'])->name('user.store');
Route::get('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/login', [UserController::class, 'validate'])->name('user.validate');

Route::middleware('auth')->group(function () {

    Route::post('/logout', [UserController::class, 'destroy'])->name('user.logout');
});


Route::get('/', function () {
    return view('home');
})->name('home');


