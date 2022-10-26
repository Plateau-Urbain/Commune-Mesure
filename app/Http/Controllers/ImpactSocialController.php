<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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

        return view('impactsocial.show', compact('place', 'auth', 'slug', 'edit'));
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

        $validateAgainst = $place->getValidator($request->all(), $hash);
        $this->validate($request, $validateAgainst);

        $new = $place->updateData($hash, $request->all());
        $place->save();

        return redirect(route('impacts.edit', compact('slug', 'auth')));
    }
}
