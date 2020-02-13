<?php

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
$router->post('/transactions', 'TransactionsController@create');
$router->get('/transactions/{id}', 'TransactionsController@show');

$router->post('/users', 'UsersController@create');
$router->get('/users', 'UsersController@index');
$router->get('/users/{id}', 'UsersController@show');
$router->post('/users/consumers', 'UsersConsumersController@create');
$router->post('/users/sellers', 'UsersSellersController@create');

