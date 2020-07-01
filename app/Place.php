<?php

namespace App;

class Place
{
    protected $storage;
    protected $coordinates = [];
    protected $cities = [];
    protected $places = [];
    protected $withPopup = false;

    public function __construct()
    {
        $this->storage = getenv('STORAGE_PATH');
    }

    public function all()
    {
        $this->build();
        return [$this->coordinates, $this->cities, $this->places];
    }

    public function withPopup()
    {
        $this->withPopup = true;
        return $this;
    }

    public function build()
    {
        // TODO: Cache into files (PSR-16)
        foreach (glob($this->storage.'*.json') as $place) {
            $json = $this->getJson($place);

            $name = basename($place, '.json');
            $title = $json->name;
            $city = $json->address->city;
            $data_chart = $json->data;
            $json->title = $name;

            if ($this->withPopup) {
                $popup = str_replace(["\r\n", "\n", '  '], '',
                    view('components/popup', ['name' => $name, 'title' => $title, 'city' => $city, 'images' => $json->photos])->render()
                );
            }

            $this->places[] = $json;
            $this->coordinates[$name] = ($this->withPopup)
                ? ['geo' => $json->geo, 'popup' => $popup]
                : ['geo' => $json->geo];
            $this->cities[$city][]= ["title" => $title, "name" => $name, "data_chart" => $data_chart];
        }

        ksort($this->cities);
    }

    protected function getJson($place)
    {
        $json = json_decode(file_get_contents($place));

        if ($json === null) {
            throw new \LogicException("Invalid json : $place", 1);
        }

        if (property_exists($json->address, 'city') === false){
            throw new \LogicException("'La ville n'existe pas' in $place", 1);
        }

        if(property_exists($json, 'data') === false){
            throw new \LogicException("'Les données sont inexistantes.' in $place", 1);
        }

        return $json;
    }
}
