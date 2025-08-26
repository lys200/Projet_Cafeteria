<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::name('plat.')->controller(PlatController::class)
    ->group(function(){

        Route::get('/', 'index')->name('index.plat');
        Route::get('/edit/{$id}', ['edit'])->name('index.plat');
        Route::get('/', 'index')->name('index.plat');
        Route::get('/', 'index')->name('index.plat');

    });
// route pour les ventes
Route::resource('vente', VenteController::class);

// route pour les plats
// Route::resource('plat', PlatController::class);

// route pour les clients
Route::resource('client', ClientController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
