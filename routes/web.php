<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;

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

Route::get('/my-stamps', [StampController::class, 'stamps'])->name('user.stamps');
Route::get('/stamps/claim/{token}', [StampController::class, 'claim'])->name('events.stamp.claim');

// Rutas de administración
Route::get('/panel-admin', [EventController::class, 'adminIndex'])->name('admin.index')->middleware('auth');
Route::delete('/admin/eventos/{event}', [EventController::class, 'destroy'])->name('admin.destroy')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    
    // Vista de la "Sala de Espera"
    Route::get('/waiting-room', [EventController::class, 'waitingRoom'])->name('events.waiting-room');

    // Acción de dar Vouch
    Route::post('/events/{event}/vouch', [EventController::class, 'vouch'])->name('events.vouch');

    // Vibecheck
    Route::get('/vibecheck/{event}', [StampController::class, 'vibecheckForm'])->name('events.vibecheck');
    
});

// 4. Rutas con parámetros dinámicos 
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');