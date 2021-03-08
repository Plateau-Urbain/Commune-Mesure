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
        $list = $place->retrivePlaces();
        $auths = $place->getAuth();
        return view('admin.view', compact('list', 'auths'));
    }

    public function publish(Request $request,$slug,$auth){
      $place = Place::find($slug);

      $list = $place->retrivePlaces();
      $auths = $place->getAuth();

      if ($place->check($auth) === false) {
        abort(403, 'Wrong authentication string');
      }
      if ($auth === str_repeat('a', 64)) {
          throw new \LogicException('Exiting, default admin hash');
      }
      $place->set('publish', !$place->get('publish'));
      $place->save();
      
      return redirect(route('admin.view', compact('list', 'auths')));
    }

}
