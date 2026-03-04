<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use Illuminate\Support\Facades\Route;

// 1. Rutas de autenticación (Breeze)
require __DIR__.'/auth.php';

// 2. Rutas que NO tienen parámetros dinámicos
Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events', [EventController::class, 'index']);

// 3. Rutas protegidas (Usuarios normales)
Route::middleware('auth')->group(function () {
    Route::resource('events', EventController::class)->except(['index', 'show']); 
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my'); 

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de administración "a mano"
Route::get('/panel-admin', [EventController::class, 'adminIndex'])->name('admin.index')->middleware('auth');
Route::delete('/admin/eventos/{event}', [EventController::class, 'destroy'])->name('admin.destroy')->middleware('auth');

// 4. Rutas con parámetros dinámicos (van AL FINAL)
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');