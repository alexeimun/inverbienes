<?php

/**
 * The Router instance.
 *
 * @var \Laravel\Lumen\Routing\Router $router
 */

$router->post('login', 'AuthController@login')
    ->post('signup', 'AuthController@signup')
    ->post('logout', 'AuthController@logout');

$router->group(['middleware' => ['auth']], function () use ($router) {
    $router->get('me', 'AuthController@me');
});
