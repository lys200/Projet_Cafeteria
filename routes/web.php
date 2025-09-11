<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PlatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VenteController;
use App\Http\Middleware\AdminMiddleware;

// Route::get('/', function () {
//     return view('welcome');
// });

// Page d'accueil publique
Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');

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



// route pour les ventes
Route::resource('vente', VenteController::class);

// Routes pour le profil utilisateur
Route::middleware(['auth'])->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Gestion des utilisateurs (admin seulement)
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});


// route pour les clients
Route::resource('client', ClientController::class)->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route de test pour vérifier que le middleware fonctionne
Route::get('/test-admin', function () {
    return 'Test admin réussi !';
})->middleware(AdminMiddleware::class);
// Route pour le tableau de bord
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');
// Routes admin seulement - CORRIGEZ ICI
    // Ajoutez ce middleware dans app/Http/Kernel.php
    // Dans la propriété $routeMiddleware, ajoutez :
    // 'admin' => \App\Http\Middleware\AdminMiddleware::class,

// Groupe admin
// Route::middleware([AdminMiddleware::class])->group(function () {
//     Route::resource('plats', PlatController::class)->except(['index', 'show']);
//     Route::resource('clients', ClientController::class);
//     Route::resource('ventes', VenteController::class);
//     Route::resource('users', UserController::class);
// });
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::resource('users', UserController::class)->except(['show', 'edit']);
    // Routes API pour les modaux
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
});

require __DIR__.'/auth.php';
