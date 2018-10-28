<?php

/**
 * The Router instance.
 *
 * @var \Laravel\Lumen\Routing\Router $router
 */

$router->group(['prefix' => 'client'], function () use ($router) {
    /**
     * Debtor routes
     */
    $router->group(['prefix' => 'debtor'], function () use ($router) {
        $router->post('', 'DebtorController@save')
            ->get('', 'DebtorController@all')
            ->get('{id}', 'DebtorController@show')
            ->delete('{id}', 'DebtorController@softDestroy');
    });
    /**
     * Creditor routes
     */
    $router->group(['prefix' => 'creditor'], function () use ($router) {
        $router->post('', 'CreditorController@save')
            ->get('', 'CreditorController@all')
            ->get('{id}', 'CreditorController@show')
            ->delete('{id}', 'CreditorController@softDestroy');
    });
});

$router->group(['prefix' => 'mortgage'], function () use ($router) {
    /**
     * Mortgage routes
     */
    $router->group(['prefix' => 'solicitude'], function () use ($router) {
        $router->post('', 'MortgageController@save')
            ->get('', 'MortgageController@all')
            ->get('{id}', 'MortgageController@show')
            ->get('interests/{id}', 'MortgageController@getInterests')
            ->get('payment/{id}', 'MortgageController@getPayments')
            ->delete('{id}', 'MortgageController@destroy');
    });

    /**
     * Creditor routes
     */
    $router->group(['prefix' => 'immovable'], function () use ($router) {
        $router->post('', 'ImmovableController@save')
            ->get('', 'ImmovableController@all')
            ->get('by_debtor/{id}/{is_related}', 'ImmovableController@getByDebtor')
            ->get('{id}', 'ImmovableController@show')
            ->delete('{id}', 'ImmovableController@softDestroy');
    });
});

$router->group(['prefix' => 'financial'], function () use ($router) {
    /**
     * Invoice routes
     */
    $router->group(['prefix' => 'invoice'], function () use ($router) {
        $router->post('', 'InvoiceController@save')
            ->get('', 'InvoiceController@all')
            ->get('get/consecutive', 'InvoiceController@getConsecutive')
            ->get('{id}', 'InvoiceController@show')
            ->put('cancel/{id}', 'InvoiceController@cancel')
            ->delete('{id}', 'InvoiceController@destroy');
    });
    /**
     * Report routes
     */
    $router->group(['prefix' => 'report'], function () use ($router) {
        $router->get('debtor/{id}/{from}/{to}', 'ReportController@debtor');
        $router->get('daily_incomes/{date}', 'ReportController@dailyIncomes');
    });
});

$router->group(['prefix' => 'company'], function () use ($router) {
    /**
     * Company routes
     */
    $router->get('', 'CompanyController@one')
        ->put('cancel/{id}', 'CompanyController@save');
});

$router->group(['prefix' => 'common'], function () use ($router) {
    /**
     * Common routes
     */
    $router->get('dashboard', 'CommonController@dashboard')
        ->get('next_to_pay', 'CommonController@nextToPay');
});
