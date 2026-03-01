<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. Rutas de autenticación (Breeze)
require __DIR__.'/auth.php';

// 2. Rutas que NO tienen parámetros dinámicos (van primero)
Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events', [EventController::class, 'index']);

// 3. Rutas protegidas (incluye el create del resource)
Route::middleware('auth')->group(function () {
    
    // Al poner el resource AQUÍ, Laravel registra /events/create ANTES que /events/{event}
    Route::resource('events', EventController::class)->except(['index', 'show']); 
    
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my'); 

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. Rutas con parámetros dinámicos (van AL FINAL)
// Esta ruta es "codiciosa", se queda con todo lo que sea /events/algo, por eso va última.
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');