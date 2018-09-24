<?php

namespace Rhemo\Providers;

use ChrisWhite\B2\Client;
use Illuminate\Support\ServiceProvider;
use Rhemo\Bridge\B2Storage;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        if($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind('storage', function () {
            return new B2Storage(new Client(env('B2_ACCOUNT_ID'), env('B2_API_KEY')));
        });
    }
}
