<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function map(Place $place)
    {
        $places= Place::retrievePlaces();

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

        $stats = $place->getStats();

        $popup = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getInfoPopup($item);
        });

        return view('home', compact('coordinates', 'stats', 'popup'));
    }

    public function search(Request $request, Place $place)
    {
        $search = $request->input('q', null);
        $results = [];

        if ($search) {
            // TODO: better validation handling
            $this->validate($request, [
                'q' => 'required|filled|string|min:1|max:255'
            ]);

            $results = Place::search($request->input('q'));
            $results->transform(function ($item) {
                    $item->url = route('place.show', ['slug' => $item->slug]);
                    $item->photo = json_decode($item->photo);
                    return $item;
            });
        }

        return view('search', compact('search', 'results'));
    }
}
