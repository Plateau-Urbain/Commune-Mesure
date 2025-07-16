<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceEnvironment;
use App\Services\EnvironmentalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Illuminate\Http\File;
use App\Services\TypeformUpdateService;

class EnvironmentalController extends Controller
{
    private $environmentalService;
    private $typeformUpdateService;

    public function __construct(EnvironmentalService $environmentalService, TypeformUpdateService $typeformUpdateService)
    {
        $this->environmentalService = $environmentalService;
        $this->typeformUpdateService = $typeformUpdateService;
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

        $questionAnswer = $this->environmentalService->getCleanedTypeformQuestionForEnvironmental($placeEnvironment);

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

        $questionAnswer = $this->environmentalService->getCleanedTypeformQuestionForEnvironmental($placeEnvironment);

        $edit = true;

        return view('environmental.show', compact('place', 'placeEnvironment', 'axes_totals', 'sub_axes_totals', 'selected_words', 'questionAnswer', 'auth', 'slug', 'edit'));
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
        $dataKey = $this->typeformUpdateService->getFirstKey($requestData);
        $data = $placeEnvironment->getData();

        // Get all the questions to check the type and the user answer against the authorized values
        $questionAnswer = $this->environmentalService->getCleanedTypeformQuestionForEnvironmental($placeEnvironment, $requestData["id"]);
        if (!isset($questionAnswer["title"])) {
            throw new \Exception('Question not found');
        }

        $result = $this->typeformUpdateService->handleUpdate($requestData, $data, $questionAnswer, $dataKey, $this->environmentalService);

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

        $process = new Process($processArgs);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            abort(500, $process->getExitCode().": ".$process->getOutput());
        }

        $lastoutput = array_filter(explode("\n", $process->getOutput()));
        $lastoutput = end($lastoutput);

        $path = Storage::putFile(
            'screenshots',
            new File($lastoutput)
        );

        if ($path === false) {
            abort(500, 'Error writing pdf file on disk');
        }

        return Storage::download($path);
    }
}
