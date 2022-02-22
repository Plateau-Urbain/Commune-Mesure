<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\Place;
use App\Mail\ImportSuccess;

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

$router->get('/_admin', ['uses' => 'AdminController@view', 'as' => 'admin.view']);
$router->get('/_admin/{slug}/{auth:[a-z0-9]+}/publish', ['uses' => 'AdminController@publish', 'as' => 'admin.publish']);
$router->get('/_admin/{slug}/{auth:[a-z0-9]+}/rehash', ['uses' => 'AdminController@rehash', 'as' => 'admin.rehash']);
$router->get('/_admin/{slug}/{auth:[a-z0-9]+}/delete', ['uses' => 'AdminController@delete', 'as' => 'admin.delete']);
$router->get('/_admin/globalCsv', ['uses' => 'AdminController@globalCsv', 'as' => 'admin.globalCsv']);

$router->get('/external/chiffres', ['uses' => 'ExternalController@chiffres', 'as' => 'chiffres']);
$router->get('/external/map', ['uses' => 'ExternalController@map', 'as' => 'external.map']);

$router->get('/les-lieux', ['uses' => 'PlaceController@list', 'as' => 'places']);
$router->get('/place/{slug}', ['uses' => 'PlaceController@show', 'as' => 'place.show']);
$router->get('/place/{slug}/export[/{to}]', ['uses' => 'PlaceController@export', 'as' => 'place.export']);

$router->get('/place/{slug}/{auth:[a-z0-9]+}/edit', ['uses' => 'PlaceController@edit', 'as' => 'place.edit']);
$router->post('/place/{slug}/{auth:[a-z0-9]+}/update/{hash}[/{id_section}]', ['uses' => 'PlaceController@update', 'as' => 'place.update']);
$router->get('/place/{slug}/{auth:[a-z0-9]+}/publish', ['uses' => 'PlaceController@publish', 'as' => 'place.publish']);
$router->get('/place/{slug}/{auth:[a-z0-9]+}/csv', ['uses' => 'PlaceController@jsonToCsv', 'as' => 'place.csv']);
$router->get('/place/{slug}/{auth:[a-z0-9]+}/toggle/{section}', ['uses' => 'PlaceController@toggle', 'as' => 'place.toggle']);

$router->post('/place/{slug}/{auth:[a-z0-9]+}/edit/galerie/add', ['uses' => 'PhotoController@add', 'as' => 'photo.add']);
$router->get('/place/{slug}/{auth:[a-z0-9]+}/edit/galerie/{index}/delete', ['uses' => 'PhotoController@delete', 'as' => 'photo.delete']);

$router->get('/les-statistiques-et-donnees-des-lieux',  ['uses' => 'ImpactsController@show', 'as' => 'impacts.show']);
$router->get('/les-partenaires', ['as' => 'partners', function () {
    return view('partenaires');
}]);

if (! App::environment('production')) {
    Route::get('/_debug/mail/import-success/{slug}', function ($slug) {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404, "Le lieu [$slug] n'existe pas");
        }

        Mail::send(new ImportSuccess($place));

        return new ImportSuccess($place);
    });
}
