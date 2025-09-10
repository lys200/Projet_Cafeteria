<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VenteController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Page d'accueil publique
Route::get('/', [HomeController::class, 'index'])->name('home');

// Redirection de la racine vers le dashboard
// Route::get('/', function () {
//     return redirect()->route('dashboard');
// });
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// route pour les plats
Route::resource('plat', PlatController::class)->middleware(['auth']);
// route pour les ventes
Route::resource('vente', VenteController::class)->middleware(['auth']);


// route pour les clients
Route::resource('client', ClientController::class)->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route pour le tableau de bord
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
