<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Agenda\TypesAgendaController;
use App\Http\Controllers\Agenda\StatusAgendaController;
use App\Http\Controllers\Agenda\AgendaController;

Route::get('/usuarios', [UserController::class, 'create'])->name('user.create');
Route::post('/usuarios', [UserController::class, 'register'])->name('user.store');
Route::get('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/login', [UserController::class, 'validateCredentials'])->name('user.validate');

Route::middleware('auth')->group(function () {

    Route::post('/logout', [UserController::class, 'destroy'])->name('user.logout');
});


//grupo de rotas da agenda
Route::prefix('agendas')->middleware(['auth'])->group(function () {
    Route::get('/', [AgendaController::class, 'index'])->name('agenda.index');
    Route::post('/eventos', [AgendaController::class, 'eventos'])->name('agenda.event');
    Route::post('/eventos/criar', [AgendaController::class, 'store'])->name('agenda.event.store');
    Route::post('/eventos/{id}', [AgendaController::class, 'update'])->name('agenda.event.update');
});

//grupo de rotas cliente
Route::prefix('cliente')->middleware(['auth'])->group(function () {
        Route::get('/visualizar', [ClientController::class, 'index'])->name('client.index');
        Route::get('clientes/create', [ClientController::class, 'create'])->name('client.create');
        Route::post('clientes', [ClientController::class, 'store'])->name('client.store');
        Route::get('clientes/{cliente}/edit', [ClientController::class, 'edit'])->name('client.edit');
        Route::put('clientes/{cliente}', [ClientController::class, 'update'])->name('client.update');
        Route::delete('clientes/{cliente}', [ClientController::class, 'destroy'])->name('client.destroy');
        Route::get('clientes/{cliente}', [ClientController::class, 'show'])->name('client.show');
});

Route::prefix('agenda')->middleware(['auth'])->group(function () {
    Route::get('tipos', [TypesAgendaController::class, 'index'])->name('tipos.index');
    Route::get('tipos/create', [TypesAgendaController::class, 'create'])->name('tipos.create');
    Route::post('tipos', [TypesAgendaController::class, 'store'])->name('tipos.store');
    Route::get('tipos/{tipo}/edit', [TypesAgendaController::class, 'edit'])->name('tipos.edit');
    Route::put('tipos/{tipo}', [TypesAgendaController::class, 'update'])->name('tipos.update');
    Route::get('tipos/{tipo}', [TypesAgendaController::class, 'show'])->name('tipos.show');
    Route::delete('tipos/{tipo}', [TypesAgendaController::class, 'destroy'])->name('tipos.destroy');

    Route::get('status', [StatusAgendaController::class, 'index'])->name('status.index');
    Route::get('status/create', [StatusAgendaController::class, 'create'])->name('status.create');
    Route::post('status', [StatusAgendaController::class, 'store'])->name('status.store');
    Route::get('status/{status}/edit', [StatusAgendaController::class, 'edit'])->name('status.edit');
    Route::put('status/{status}', [StatusAgendaController::class, 'update'])->name('status.update');
    Route::get('status/{status}', [StatusAgendaController::class, 'show'])->name('status.show');
    Route::delete('status/{status}', [StatusAgendaController::class, 'destroy'])->name('status.destroy');
});

Route::get('/', function () {
    return view('home');
})->name('home');


