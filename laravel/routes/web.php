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


//grupo de rotas da agenda
Route::prefix('agendas')->middleware(['auth'])->group(function () {
    //cadastro de agenda, visualizacao
    //cadastro de tipo agenda e status
    //   exemplo de rotas
        // Route::get('/agendamentos', [agendaController::class, 'index'])->name('index');
});

//grupo de rotas cliente
Route::prefix('cliente')->middleware(['auth'])->group(function () {
    //cadastro e alteracao de cliente
    //visualizacao filtro de pesquisa
    //   exemplo de rotas
        // Route::get('/agendamentos', [agendaController::class, 'index'])->name('index');
});


Route::get('/', function () {
    return view('home');
})->name('home');


