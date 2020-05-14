<?php

namespace App\Http\Controllers;

class PlaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function show($slug)
    {
        $json = getenv('STORAGE_PATH').$slug.'.json';
        if (! file_exists($json)) {
            abort(404);
        }

        $place = json_decode(file_get_contents($json));

        return view('place.show', compact('place'));
    }
}
