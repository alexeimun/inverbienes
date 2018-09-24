<?php

/**
 * The Router instance.
 *
 * @var \Laravel\Lumen\Routing\Router $router
 */

$router->post('login', 'AuthController@login')
    ->post('signup', 'AuthController@signup')
    ->post('fb_auth', 'AuthController@authFB')
    ->get('verify_email/{token}', 'AuthController@verifyEmail');

$router->group(['middleware' => ['auth']], function () use ($router) {
    $router->get('me', 'AuthController@me');
});

$router->group(['prefix' => 'password'], function () use ($router) {
    $router->post('email', 'PasswordController@postEmail')
        ->post('reset','PasswordController@redeemCode')
        ->post('change','PasswordController@changePassword');
});

$router->group(['prefix' => 'landing'], function () use ($router) {
    $router->post('register', 'LandingController@register');
});
