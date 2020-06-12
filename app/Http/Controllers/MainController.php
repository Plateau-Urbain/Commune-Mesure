<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function map()
    {
        [$coordinates,$cities] = $this->getAllPlaces();

        return view('home', compact('coordinates', 'cities'));
    }

    public function places(){
        [$coordinates,$cities] = $this->getAllPlaces();
        return view('places', compact('coordinates', 'cities'));
    }

    private function getAllPlaces(){
        $storage = getenv('STORAGE_PATH');

        // TODO: Cache into files (PSR-16)
        $coordinates = [];
        $cities = [];
        foreach (glob($storage.'*.json') as $place) {
            $json = json_decode(file_get_contents($place));
            $name = basename($place, '.json');
            $title = $json->name;
            if(property_exists($json->address, 'city') === false){
              throw new \LogicException("La ville n'existe pas.", 1);

            }
            $city = $json->address->city;
            $data_chart = $json->data;
            if(property_exists($json, 'data') === false){
              throw new \LogicException("Les données sont inexistantes.", 1);

            }
            $popup = str_replace(["\r\n", "\n", '  '], '', view('components/popup', ['name' => $name, 'title' => $title, 'city' => $city, "images" => $json->photos])->render());

            $coordinates[$name] = ['geo' => $json->geo, 'popup' => $popup];

            if ($city) {
                $cities[$city][]= ["title" => $title, "name" => $name, "data_chart" => $data_chart];
            }
        }
        ksort($cities);
        return [$coordinates, $cities];
    }
}
