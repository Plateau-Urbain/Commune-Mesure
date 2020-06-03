<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    public function map()
    {
        $storage = getenv('STORAGE_PATH');

        // TODO: Cache into files (PSR-16)
        $coordinates = [];
        $cities = [];
        foreach (glob($storage.'*.json') as $place) {
            $json = json_decode(file_get_contents($place));
            $name = basename($place, '.json');
            $title = $json->name;
            $city = (property_exists($json, 'city')) ? $json->city : null;

            $popup = str_replace(["\r\n", "\n", '  '], '', view('components/popup', ['name' => $name, 'title' => $title, 'city' => $city, "images" => $json->photos])->render());

            $coordinates[$name] = ['geo' => $json->geo, 'popup' => $popup];

            if ($city) {
                $cities[strtoupper($city)] = $city;
            }
        }

        return view('home', compact('coordinates', 'cities'));
    }
}
