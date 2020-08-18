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
$router->get('/place/{slug}', ['uses' => 'PlaceController@show', 'as' => 'place.show']);
$router->get('/documentation', ['uses' => 'SurveyController@show', 'as' => 'survey.show']);
$router->get('/les-donnees',  ['uses' => 'ImpactsController@datas', 'as' => 'impacts.datas']);
$router->get('/les-statistiques-et-donnees-des-lieux',  ['uses' => 'ImpactsController@show', 'as' => 'impacts.show']);
$router->get('/les-statistiques',  ['uses' => 'ImpactsController@statistics', 'as' => 'impacts.statistics']);
$router->get('/les-institutions',  function () {
    return view('institutions');
});
$router->get('/getJsonD3Doughnut', ['uses' =>"PlaceController@getJsonD3Doughnut", 'as' => "place.getJsonD3Doughnut"]);
$router->get('/les-lieux', ['uses' => 'MainController@places', 'as' => 'places']);

$router->get('/contact-us',  function () {
    return view('contact-us');
});
