<?php

namespace Bienes\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Bienes\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot() {
        $this->registerRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function registerRoutes() {
        /*
         * Routes for version 1
         */
        Route::prefix('api')
            ->middleware(['jwt.auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/routes-v1.php'));

        /*
         * Routes for auth
         */
        Route::prefix('auth')
            ->namespace('Bienes\Http\Controllers\Auth')
            ->group(base_path('routes/routes-auth.php'));

        /*
         * Routes for authentification in ecosystem
         */
        Route::middleware('web')
            ->namespace($this->namespace)
            ->middleware(['active.user'])
            ->group(base_path('routes/web.php'));

    }
}
