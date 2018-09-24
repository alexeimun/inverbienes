<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
}
catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->withFacades();

$app->withEloquent();

/**
 *  Configuration files
 */

$app->configure('auth');
$app->configure('cors');
$app->configure('constants');
$app->configure('ide-helper');
$app->configure('mail');
$app->configure('queue');
$app->configure('services');

app('translator')->setLocale('es');
$app->make('queue');

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Rhemo\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Rhemo\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->routeMiddleware([
    'cors' => Barryvdh\Cors\HandleCors::class,
    'auth' => Rhemo\Http\Middleware\Authenticate::class,
]);

$app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);

// $app->middleware([
//    App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(Rhemo\Providers\AppServiceProvider::class);
$app->register(Illuminate\Auth\Passwords\PasswordResetServiceProvider::class);
$app->register(Rhemo\Providers\AuthServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(Barryvdh\Cors\ServiceProvider::class);
$app->register(Illuminate\Mail\MailServiceProvider::class);
$app->register(Rhemo\Providers\MailersServiceProvider::class);
$app->register(Illuminate\Notifications\NotificationServiceProvider::class);
$app->register(OneSignalNotifier\OneSignal\OneSignalServiceProvider::class);
//$app->register(\Illuminate\Queue\QueueServiceProvider::class);


// $app->register(App\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'prefix' => 'v1',
    'middleware' => ['auth', 'cors'],
    'namespace' => 'Rhemo\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/routes-v1.php';
});

$app->router->group([
    'middleware' => 'cors',
    'prefix' => 'auth',
    'namespace' => 'Rhemo\Http\Controllers\Auth',
], function ($router) {
    require __DIR__ . '/../routes/routes-auth.php';
});
$app->router->get('','Rhemo\Http\Controllers\Auth\LandingController@version');

return $app;
