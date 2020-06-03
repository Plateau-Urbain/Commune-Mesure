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
$router->get('/les-donnees',  function () {
    return view('statistics');
});
$router->get('/les-institutions',  function () {
    return view('institutions');
});
$router->get('/les-lieux',  function () {
    return view('places');
});

$router->get('/contact-us',  function () {
    return view('contact-us');
});




