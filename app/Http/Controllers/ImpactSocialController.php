<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Services\SocialImpactService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Illuminate\Http\File;
use App\Services\TypeformUpdateService;

class ImpactSocialController extends Controller
{
    private $socialImpactService;
    private $typeformUpdateService;

    public function __construct(SocialImpactService $socialImpactService, TypeformUpdateService $typeformUpdateService)
    {
        $this->socialImpactService = $socialImpactService;
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

        return view('impactsocial.show', compact('place'));
    }

    public function edit($slug, $auth)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $edit = true;

        $questionAnswer = $this->socialImpactService->getCleanedTypeformQuestionForSocialImpact($place);

        return view('impactsocial.show', compact('place', 'auth', 'slug', 'edit', 'questionAnswer'));
    }

    public function update(Request $request, $slug, $auth, $hash)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $this->validate($request, [
            'id' => 'required|filled|string|min:1|max:255'
        ]);

        $requestData = $request->all();
        $dataKey = $this->typeformUpdateService->getFirstKey($requestData);
        $data = json_decode(json_encode($place->getData()), true);

        $questionAnswer = $this->socialImpactService->getCleanedTypeformQuestionForSocialImpact($place, $requestData["id"]);
        if (!isset($questionAnswer["title"])) {
            throw new \Exception('Question not found');
        }

        $result = $this->typeformUpdateService->handleUpdate($requestData, $data, $questionAnswer, $dataKey, $this->socialImpactService);

        if ($result) {
            $place->setData(json_encode($data));
            $place->save();
        } else {
            throw new \Exception('Question key does not exists');
        }

        return redirect(route('impacts.edit', compact('slug', 'auth')));
    }

    public function export(Request $request, $slug)
    {
        $place = Place::find($slug);
        if ($place === false) {
            abort(404);
        }

        $processArgs = ['bash', base_path().'/bin/export.sh', 'social', $place->getSlug()];

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
