<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(Place $place)
    {
        $list = Place::retrievePlaces('latest');
        $auths = $place->getAuth();
        return view('admin.view', compact('list', 'auths'));
    }

    public function publish(Request $request,$slug,$auth){
      $place = Place::find($slug);

      if ($place->check($auth) === false) {
        abort(403, 'Wrong authentication string');
      }
      if ($auth === str_repeat('a', 64)) {
          throw new \LogicException('Exiting, default admin hash');
      }
      $place->set('publish', !$place->get('publish'));
      $place->save();

      return redirect(route('admin.view'));
    }

    public function globalCsv(Request $request, Place $place){
      $list = Place::retrievePlaces();
      $auths = $place->getAuth();

      header("Content-type: text/csv");
      header("Content-disposition: attachment; filename = global.csv");
      $csv = "";

      foreach ($list as $place){
        $csv = $place->exportCsv($csv,$auths[$place->getSlug()]);
      }
      echo ($csv);
      exit;
    }

    public function rehash(Request $request, $slug, $auth)
    {
        $place = Place::find($slug);

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $res = $place->updateHash();

        $request->session()->flash('update', 'Hash mise à jour : ' . $place->get('name'));
        return redirect(route('admin.view'));
    }
}
