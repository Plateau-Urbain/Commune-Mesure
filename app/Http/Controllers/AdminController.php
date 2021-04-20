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

    public function globalCsv(Request $request, Place $place){
      $list = $place->retrivePlaces();
      $auths = $place->getAuth();

      header("Content-type: text/csv");
      header("Content-disposition: attachment; filename = global.csv");

      $fichier_csv = fopen("global.csv", 'w');

      foreach ($list as $place){
        fputcsv($fichier_csv,array(route('place.show',['slug' => $place->getSlug() ]),$place->getSlug(),'nom',$place->getSlug()));
        fputcsv($fichier_csv,array(route('place.show',['slug' => $place->getSlug() ]),$place->getSlug(),'page_admin',route('place.edit', ['slug' => $place->getSlug(), 'auth' => $auths[$place->getSlug()]])));
        fputcsv($fichier_csv,array(route('place.show',['slug' => $place->getSlug() ]),$place->getSlug(),'clé',$auths[$place->getSlug()]));
        if($place->get('publish')){
          $status='visible';
        }
        else{
          $status='non visible';
        }
        fputcsv($fichier_csv,array(route('place.show',['slug' => $place->getSlug() ]),$place->getSlug(),'status',$status));
        // fputcsv($fichier_csv,array(route('place.show',['slug' => $place->getSlug() ]),$place->getSlug(),,));
      }

      fclose($fichier_csv);
      readfile("global.csv");
      exit;
    }

}
