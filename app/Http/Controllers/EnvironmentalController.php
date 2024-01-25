<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceEnvironment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class EnvironmentalController extends Controller
{
    public function show($slug)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->isPublish() === false) {
            return view('place.unpublished', compact('place'));
        }

        $placeEnvironment = PlaceEnvironment::findByPlaceId($place->getId());

        return view('environmental.show', compact('place', 'placeEnvironment'));
    }
}
