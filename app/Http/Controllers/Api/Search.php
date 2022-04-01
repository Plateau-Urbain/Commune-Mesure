<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;

class Search extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function place(Request $request, Place $place)
    {
        if ($request->filled('q') === false) {
            return response()->json([
                'success' => true, 'count' => 0, 'results' => []
            ]);
        }

        $this->validate($request, [
            'q' => 'required|filled|string|min:1|max:255'
        ]);

        $search_results = Place::search($request->input('q'));
        $search_results->transform(function ($item) {
                $item->url = route('place.show', ['slug' => $item->slug]);
                return $item;
        });

        $response = ['success' => true, 'request' => $request->input('q'), 'count' => count($search_results), 'results' => $search_results];
        return response()->json($response);
    }
}
