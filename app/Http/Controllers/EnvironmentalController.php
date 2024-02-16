<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceEnvironment;
use App\Services\EnvironmentalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $placeEnvironment = PlaceEnvironment::where('place_id', $place->getId())->first();

        $score = $this->environmentalService->calculateAnswerScore($placeEnvironment);
        $axes_totals = $this->environmentalService->calculateDimensionScore($score);
        $sub_axes_totals = $this->environmentalService->calculateSubDimensionScore($score);
        $selected_words = $this->environmentalService->getWordsCloud($score);

        $questionAnswer = $this->environmentalService->getCleanedTypeformQuestion($placeEnvironment);

        return view('environmental.show', compact('place', 'placeEnvironment', 'axes_totals', 'sub_axes_totals', 'selected_words', 'questionAnswer'));
    }

    public function edit($slug, $auth)
    {
        $place = Place::find($slug);
        $placeEnvironment = PlaceEnvironment::where('place_id', $place->getId())->first();

        if ($place === false || !$placeEnvironment) {
            abort(404);
        }

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $score = $this->environmentalService->calculateAnswerScore($placeEnvironment);
        $axes_totals = $this->environmentalService->calculateDimensionScore($score);
        $sub_axes_totals = $this->environmentalService->calculateSubDimensionScore($score);
        $selected_words = $this->environmentalService->getWordsCloud($score);

        $questionAnswer = $this->environmentalService->getCleanedTypeformQuestion($placeEnvironment);

        $edit = true;

        return view('environmental.show', compact('place', 'placeEnvironment', 'axes_totals', 'sub_axes_totals', 'selected_words', 'questionAnswer', 'auth', 'slug', 'edit'));
    }

    private function updateArrayValueWithKeys(&$array, $keysString, $newValue) {
        $keys = explode("__", $keysString);
        $tempArray = &$array;
        foreach ($keys as $key) {
            if (!isset($tempArray[$key])) {
                return false;
            }
            $tempArray = &$tempArray[$key];
        }
        $tempArray = $newValue;
        return true;
    }

    private function getFirstKey($array) {
        $keys = array_keys($array);
        return isset($keys[0]) ? $keys[0] : null;
    }

    public function update(Request $request, $slug, $auth, $hash, $id_section)
    {
        $this->validate($request, [
            'id' => 'required|filled|string|min:1|max:255'
        ]);

        $place = Place::find($slug);
        $placeEnvironment = PlaceEnvironment::where('place_id', $place->getId())->first();

        if ($place === false || !$placeEnvironment) {
            abort(404);
        }

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $requestData = $request->all();
        $dataKey = $this->getFirstKey($requestData);
        $data = $placeEnvironment->getData();

        // Get all the questions to check the type and the user answer against the authorized values
        $questionAnswer = $this->environmentalService->getCleanedTypeformQuestion($placeEnvironment, $requestData["id"]);
        if (!isset($questionAnswer["title"])) {
            throw new \Exception('Question not found');
        }

        switch ($questionAnswer['type']) {
            case 'checkbox':
                if (!$this->environmentalService->authorizedAnswer($questionAnswer, array_keys($requestData[$dataKey]))) {
                    throw new \Exception('Answer not authorized');
                }
                $result = $this->updateArrayValueWithKeys($data, $dataKey, array_keys($requestData[$dataKey]));
                break;
            case 'toggle':
                if (!$this->environmentalService->authorizedAnswer($questionAnswer, $requestData[$dataKey])) {
                    throw new \Exception('Answer not authorized');
                }
                $result = $this->updateArrayValueWithKeys($data, $dataKey, $requestData[$dataKey]);
                break;
            case 'select':
                if (!$this->environmentalService->authorizedAnswer($questionAnswer, $requestData[$dataKey])) {
                    throw new \Exception('Answer not authorized');
                }
                $result = $this->updateArrayValueWithKeys($data, $dataKey, [$requestData[$dataKey]]);
                break;
            case 'text':
                $result = $this->updateArrayValueWithKeys($data, $dataKey, htmlspecialchars($requestData[$dataKey]));
                break;
            default:
                throw new \Exception('Unsupported question type' . $questionAnswer['type']);
                break;
        }

        if ($result) {
            $placeEnvironment->data = $data;
            $placeEnvironment->save();
        } else {
            throw new \Exception('Question key does not exists');
        }

        return redirect(route('environment.edit', compact('slug', 'auth')).'#'.$id_section);
    }

    public function export(Request $request, $slug)
    {
        $place = Place::find($slug);
        if ($place === false) {
            abort(404);
        }

        $placeEnvironment = PlaceEnvironment::where('place_id', $place->getId())->first();
        if ($placeEnvironment === false) {
            abort(404);
        }

        $processArgs = ['bash', base_path().'/bin/export.sh', 'environmental', $place->getSlug()];

        $file = $place->export("pdf", false, $processArgs);

        return Storage::download($file);
    }
}
