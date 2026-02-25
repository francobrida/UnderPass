<?php

use App\Http\Controllers\EventController; // ¡Importante!
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas de UnderPass
|--------------------------------------------------------------------------
*/

// Ahora la raíz de la web vuelve a ser tu lista de eventos
Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Solo con Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // CRUD de Eventos: Solo para usuarios registrados
    // Usamos except porque index y show ya están arriba como públicos
    Route::resource('events', EventController::class)->except(['index', 'show']);

    // Perfil de usuario (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';