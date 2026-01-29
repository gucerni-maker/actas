<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Asegura Bootstrap 5 (por si usabas Tailwind por defecto)
        Paginator::useBootstrapFive();

        // Establece tus vistas por defecto (normal y simple)
        Paginator::defaultView('components.pagination.stacked');
        Paginator::defaultSimpleView('components.pagination.stacked'); // o 'components.pagination.stacked-simple' si la creas
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
