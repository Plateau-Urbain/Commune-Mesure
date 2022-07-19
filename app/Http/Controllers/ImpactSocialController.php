<?php

namespace App\Http\Controllers;

use App\Models\Place;

class ImpactSocialController extends Controller
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

        return view('impactsocial.show', compact('place'));
    }
}
