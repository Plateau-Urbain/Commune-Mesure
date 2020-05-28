<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    public function map()
    {
        $storage = getenv('STORAGE_PATH');

        // TODO: Cache into files (PSR-16)
        $coordinates = [];
        foreach (glob($storage.'*.json') as $place) {
            $json = json_decode(file_get_contents($place));
            $name = basename($place, '.json');
            $title = $json->name;
            $popup = str_replace(["\r\n", "\n", '  '], '', view('components/popup', ['name' => $name, 'title' => $title, "images" => $json->photos])->render());

            $coordinates[$name] = ['geo' => $json->geo, 'popup' => $popup];
        }

        return view('home', compact('coordinates'));
    }
}
