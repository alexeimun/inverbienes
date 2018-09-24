<?php

/**
 * The Router instance.
 *
 * @var \Laravel\Lumen\Routing\Router $router
 */

$router->group(['prefix' => 'social'], function () use ($router) {

    $router->group(['prefix' => 'post'], function () use ($router) {
        $router->get('own', 'SocialController@posts')
            ->get('user/{id}', 'SocialController@postsFrom')
            ->get('', 'SocialController@timeline')
            ->get('post/{id}', 'SocialController@getPostById')
            ->get('tagged_horse/{user_id}/{horse_id}', 'SocialController@getTaggedHorsePosts')
            ->post('', 'SocialController@savePost')
            ->put('', 'SocialController@createPost')
            ->post('video', 'SocialController@uploadVideo')
            ->delete('{id}', 'SocialController@destroy')
            ->post('comment/{id}', 'SocialController@comment')
            ->get('comments/{id}', 'SocialController@getPostComments');
    });

    $router->put('like/{likeable_id}', 'SocialController@like')
        ->get('search/{keyword}/{page}', 'SocialController@search')
        ->get('search/{keyword}', 'SocialController@search')
        ->get('followers', 'SocialController@followers')
        ->get('following/{user_id}', 'SocialController@following')
        ->get('followme/{user_id}', 'SocialController@followme')
        ->post('follow/{profile_id}', 'SocialController@follow');

    $router->group(['prefix' => 'highlight'], function () use ($router) {
        $router->get('members', 'SocialController@getHighligths')
            ->get('active', 'SocialController@activeProfiles');
    });
});

$router->group(['prefix' => 'prize'], function () use ($router) {
    $router->post('', 'PrizeController@save')
        ->delete('{id}', 'PrizeController@destroy');
});

$router->group(['prefix' => 'horse'], function () use ($router) {
    $router->post('', 'HorseController@save')
        ->get('', 'HorseController@all')
        ->get('all', 'HorseController@globalHorses')
        ->get('user_horses/{user_id}', 'HorseController@userHorses')
        ->get('{id}', 'HorseController@show')
        ->get('colors/and/races', 'HorseController@colorsAndRaces')
        ->delete('{id}', 'HorseController@softDestroy');

    $router->group(['prefix' => 'genealogy'], function () use ($router) {
        $router->put('{id}', 'HorseController@saveGenealogy')
            ->get('{id}', 'HorseController@getGenealogy')
            ->post('search/ancestor', 'HorseController@searchAncestor')
            ->get('search/name/{keyword}', 'HorseController@searchGenealogyByName');
    });

    $router->group(['prefix' => 'color'], function () use ($router) {
        $router->post('', 'HorseColorController@save')
            ->get('all', 'HorseColorController@all')
            ->delete('{id}', 'HorseColorController@destroy');
    });

    $router->group(['prefix' => 'race'], function () use ($router) {
        $router->post('', 'HorseRaceController@save')
            ->get('all', 'HorseRaceController@all')
            ->delete('{id}', 'HorseRaceController@destroy');
    });

    $router->group(['prefix' => 'ride'], function () use ($router) {
        $router->post('', 'RideController@save')
            ->get('all', 'RideController@all')
            ->get('{id}', 'RideController@show')
            ->get('measurement/{id}', 'RideController@getMeasurement')
            ->delete('{id}', 'RideController@destroy');
    });

    $router->group(['prefix' => 'certificate'], function () use ($router) {
        $router->put('{id}', 'CertificateController@saveCertifcate')
            ->get('all', 'CertificateController@getCertificates')
            ->get('fetch/{id}', 'CertificateController@getCertificate')
            ->patch('{id}/{value}', 'CertificateController@validateCertificate');
    });
});

$router->group(['prefix' => 'user'], function () use ($router) {
    $router->put('', 'UserController@editCurrentUser')
        ->post('deactivate', 'UserController@deactivate')
        ->delete('{id}', 'UserController@softDestroy')
        ->patch('{id}', 'UserController@restore')
        ->get('', 'UserController@all')
        ->get('{id}', 'UserController@show');

    $router->group(['prefix' => 'contact'], function () use ($router) {
        $router->post('', 'UserController@saveContact');
    });
    $router->group(['prefix' => 'forgot'], function () use ($router) {
        $router->post('', 'UserController@forgotPassword')
            ->post('deactivate', 'UserController@deactivate')
            ->post('confirmation', 'UserController@formForgotPassword');
    });

});

$router->group(['prefix' => 'calendar'], function () use ($router) {
    $router->get('', 'CalendarController@all')
        ->get('scheduled', 'CalendarController@scheduled')
        ->post('', 'CalendarController@save')
        ->post('mycalendar', 'CalendarController@mycalendar')
        ->post('schedule/{id}', 'CalendarController@schedule')
        ->post('link', 'CalendarController@vincular')
        ->delete('{id}', 'CalendarController@destroy');

    $router->group(['prefix' => 'rhemo'], function () use ($router) {
        $router->get('{id}', 'CalendarController@getRhemoEvent')
            ->get('', 'CalendarController@getRhemoEvents')
            ->post('', 'CalendarController@saveRhemoEvent')
            ->delete('{id}', 'CalendarController@removeRhemoEvent');
    });
});

$router->group(['prefix' => 'highlight'], function () use ($router) {
    $router->post('', 'HighlightedController@save')
        ->get('', 'HighlightedController@all')
        ->get('{id}', 'HighlightedController@show')
        ->delete('{id}', 'HighlightedController@destroy');
});

$router->group(['prefix' => 'notification'], function () use ($router) {
    $router->get('', 'NotificationController@getByUser');
});

$router->group(['prefix' => 'shop'], function () use ($router) {
    $router->post('preorder', 'ShopController@preorder')
        ->get('video', 'ShopController@video');

    $router->group(['prefix' => 'offer'], function () use ($router) {
        $router->get('', 'ShopController@all')
            ->get('{id}', 'ShopController@show')
            ->get('active/offers', 'ShopController@getActiveOffers')
            ->get('category/{category}', 'ShopController@getByCategory')
            ->delete('{id}', 'ShopController@destroy')
            ->post('', 'ShopController@save')
            ->post('comment/{id}', 'ShopController@comment')
            ->get('comments/{id}', 'ShopController@getOfferComments')
            ->put('like/{likeable_id}', 'ShopController@like');
    });

});
