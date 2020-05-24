<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function map($slug=null)
    {
        $storage = getenv('STORAGE_PATH');

        // TODO: Cache into files (PSR-16)
        $coordinates = [];
        foreach (glob($storage.'*.json') as $place) {
            $json = json_decode(file_get_contents($place));
            $name = basename($place, '.json');
            $title = $json->name;
            $photos = null;
            $popup = str_replace(["\r\n", "\n", '  '], '', view('components/popup', ['name' => $name, 'title' => $title, "images" => $json->photos])->render());

            $coordinates[$name] = ['geo' => $json->geo, 'popup' => $popup];
        }
        $place = null;
        if(!is_null($slug)){
            $json = getenv('STORAGE_PATH').$slug.'.json';
            if (! file_exists($json)) {
                abort(404);
            }

            $place = json_decode(file_get_contents($json));
        }

        return view('map', compact('coordinates', 'place'));
    }
}
