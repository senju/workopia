<?php

$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingsController@index');
$router->get('/listings/create', 'ListingsController@create');
$router->get('/listings/{id}', 'ListingsController@show');
$router->get('listings/edit/{id}', 'ListingsController@edit');
$router->post('/listings', 'ListingsController@store');
$router->put('/listings/edit/{id}', 'ListingsController@update');
$router->delete('/listings/{id}', 'ListingsController@destroy');

