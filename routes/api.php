<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'pinjaman/v1', 'namespace' => 'V1'], function () use ($router) {
    $router->post('/inquiryPinjaman', 'PinjamanController@inquirypinjaman');
    $router->post('/createPinjaman', 'PinjamanController@createpinjaman');
    $router->post('/updatePinjaman', 'PinjamanController@updatepinjaman');
});

$router->group(['prefix' => 'customer/v1', 'namespace' => 'V1'], function () use ($router) {
    $router->post('/inquiryCustomer', 'CustomerController@inquirycustomer');
    $router->post('/createCustomer', 'CustomerController@createcustomer');
    $router->post('/updateCustomer', 'CustomerController@updatecustomer');
    $router->post('/deleteCustomer', 'CustomerController@deletecustomer');
});
