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

$router->get('/', ['uses' => 'MainController@map', 'as' => 'map']);
$router->get('/place/{slug}', ['uses' => 'PlaceController@show', 'as' => 'place.show']);
$router->get('/documentation',  function () {
    return view('documentation');
});
$router->get('/les-donnees',  ['uses' => 'ImpactsController@datas', 'as' => 'impacts.datas']);
$router->get('/les-statistiques-et-donnees-des-lieux',  ['uses' => 'ImpactsController@show', 'as' => 'impacts.show']);
$router->get('/les-statistiques',  ['uses' => 'ImpactsController@statistics', 'as' => 'impacts.statistics']);
$router->get('/les-institutions',  function () {
    return view('institutions');
});
$router->get('/les-lieux', ['uses' => 'MainController@places', 'as' => 'places']);

$router->get('/contact-us',  function () {
    return view('contact-us');
});
