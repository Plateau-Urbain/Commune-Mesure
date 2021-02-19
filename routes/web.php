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

// Reverse proxy workaround
$proxy_url    = getenv('PROXY_URL');
$proxy_schema = getenv('PROXY_SCHEMA');

if (!empty($proxy_url)) {
   URL::forceRootUrl($proxy_url);
}

if (!empty($proxy_schema)) {
   URL::forceScheme($proxy_schema);
}

$router->get('/', ['uses' => 'MainController@map', 'as' => 'map']);

$router->get('/les-lieux[/{sortBy}]', ['uses' => 'PlaceController@list', 'as' => 'places']);

$router->get('/_admin', ['uses' => 'AdminController@view', 'as' => 'admin.view']);

$router->get('/place/{slug}', ['uses' => 'PlaceController@show', 'as' => 'place.show']);
$router->get('/place/{slug}/{auth:[a-z0-9]+}/edit', ['uses' => 'PlaceController@edit', 'as' => 'place.edit']);
$router->post('/place/{slug}/{auth:[a-z0-9]+}/update', ['uses' => 'PlaceController@update', 'as' => 'place.update']);


$router->get('/place/{slug}/{auth:[a-z0-9]+}/toggle/{section}', ['uses' => 'PlaceController@toggle', 'as' => 'place.toggle']);

$router->get('/les-statistiques-et-donnees-des-lieux',  ['uses' => 'ImpactsController@show', 'as' => 'impacts.show']);
$router->get('/les-partenaires', ['as' => 'partners', function () {
    return view('partenaires');
}]);
