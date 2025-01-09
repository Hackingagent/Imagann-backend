<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route; // Add this line
use App\Http\Middleware\VerifyCsrfToken;
use Fruitcake\Cors\HandleCors;

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

    public function boot()
    {
        Route::middleware('verify.csrf.token')->group(base_path('routes/api.php'));
        Route::middleware('api')
        ->prefix('api')
        ->group(base_path('routes/api.php'));

        $this->app['router']->middleware('api', HandleCors::class);
    }
}
