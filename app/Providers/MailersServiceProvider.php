<?php

namespace Rhemo\Providers;

use Illuminate\Support\ServiceProvider;
use Rhemo\Mail\Mailers;

class MailersServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton(Mailers::class, function ($app) {
            return new Mailers($app->make('mailer'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [Mailers::class];
    }

}