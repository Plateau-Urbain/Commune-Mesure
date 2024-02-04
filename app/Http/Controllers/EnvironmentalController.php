<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceEnvironment;
use App\Services\EnvironmentalService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class EnvironmentalController extends Controller
{
    private $environmentalService;

    public function __construct(EnvironmentalService $environmentalService)
    {
        $this->environmentalService = $environmentalService;
    }

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

        $score = $this->environmentalService->calculateAnswerScore($placeEnvironment);
        $axes_totals = $this->environmentalService->calculateDimensionScore($score);
        $sub_axes_totals = $this->environmentalService->calculateSubDimensionScore($score);
        $selected_words = $this->environmentalService->getWordsCloud($score);

        return view('environmental.show', compact('place', 'placeEnvironment', 'axes_totals', 'sub_axes_totals', 'selected_words'));
    }
}
