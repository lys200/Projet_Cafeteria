<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // Créer le lien symbolique pour les images
        if (!file_exists(public_path('storage/images'))) {
            symlink(storage_path('images'), public_path('storage/images'));
        }
    }
}
