<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Section;
use Illuminate\Http\Request;

class PlaceController extends Controller
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

        $sections = $place->getSections();
        $this->sortDataInsee($place->getData());

        return view('place.show', compact('place', 'sections'));
    }

    public function list(Place $place, $sortBy = null)
    {
        $places = $place->list();

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

        // if(isset($sortBy)){
        //   $place->sortNumericPlacesBy($sortBy);
        //   $selected = explode('-', $sortBy)[1];
        // }else{
        //   $place->sortPlacesBy('name');
        //   $selected = "default_az";
        // }

        return view('places', compact('places', 'coordinates'));
    }

    public function edit($slug, $auth)
    {
        $place = Place::find($slug);

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        if ($place === false) {
            abort(404);
        }

        $sections = $place->getSections();
        $this->sortDataInsee($place->getData());

        // Pour indiquer à la vue que c'est en mode édition
        $edit = true;

        return view('place.show', compact('place', 'auth', 'slug', 'edit', 'sections'));
    }

    /**
     * Toggle visibility of a section
     *
     * @param Request $request The request
     * @param string $slug The place name sluggified
     * @param string $auth The authentication string
     * @param string $section The section name
     *
     * @return Response
     */
    public function toggle(Request $request, $slug, $auth, $section)
    {
        $place = Place::find($slug);

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $s = $place->toggleVisibility($section);
        $res = $s->save();

        $flash = ['success' => $res, 'section' => $section];
        return redirect(route('place.edit', compact('slug', 'auth')).'#'.$section);
    }

    public function update(Request $request,$slug,$auth){
       $place = Place::find($slug);

       if ($place->check($auth) === false) {
         abort(403, 'Wrong authentication string');
       }
       if ($auth === str_repeat('a', 64)) {
           throw new \LogicException('Exiting, default admin hash');
       }

       $place->set($request->chemin,$request->champ);

       $place->save();

       return redirect(route('place.edit', compact('slug', 'auth')));
    }

    public function editGalerie($slug,$auth){
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

      $chemin = 'photos';
      return view('components.modals.modalEditionGalerie',compact('place', 'slug','auth','edit','chemin','photos'));
    }


    public function updateGalerie(Request $request,$slug,$auth){
        $place = Place::find($slug);
        if ($place->check($auth) === false) {
          abort(403, 'Wrong authentication string');
        }
        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        function get_extension($nom) {
          $nom = explode(".", $nom);
          $nb = count($nom);
          return strtolower($nom[$nb-1]);
        }
        $extensions = array('jpg','jpeg','png');
        $edit = true;
        $chemin = 'photos';

        if(isset($_POST['supprimer'])){
          print_r($_POST);
          $array_photos = explode(',',$place->get('photos'));
          unset($array_photos[$_POST['supprimer']]);
          // print_r($array_photos);
          $photos= implode(',',$array_photos);
          $place->set('photos',$photos);
          $place->save();
          $_POST=array();
          return view('components.modals.modalEditionGalerie',compact('place', 'slug','auth','edit','chemin'));
        }

        elseif(isset($_POST['ajouter'])){
          if( (!in_array( get_extension($_FILES['image']['name']), $extensions)))
          {
            echo("Ce n'est pas une image");
            $_POST=array();
            return view('components.modals.modalEditionGalerie',compact('place', 'slug','auth','edit','chemin'));
          }
          if( file_exists($_FILES['image']['tmp_name']) and filesize($_FILES['image']['tmp_name']) > 3027*3072){
            echo("Pas la bonne taille");
            $_POST=array();
            return view('components.modals.modalEditionGalerie',compact('place', 'slug','auth','edit','chemin'));
          }
          $name=$_FILES['image']['name'];
          $dossier = '../public/images/lieux/';
          move_uploaded_file( $_FILES['image']['tmp_name'], $dossier . basename($_FILES['image']['name']));
          $place->set('photos',$place->get('photos').",".$name);
          $place->save();
          $_POST=array();
          return view('components.modals.modalEditionGalerie',compact('place', 'slug','auth','edit','chemin'));
        }

        else{
          echo('non');
          $_POST=array();
          return view('place.show', compact('place', 'auth', 'slug', 'edit', 'sections'));
        }
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
      return redirect(route('place.edit', compact('slug', 'auth')));
    }

    protected function sortDataInsee($place){
        //Sort insee object data on each zone map
        $insee = $place->data->insee;
        foreach ($insee as $zone => $datas) {
            foreach ($datas as $key => $data) {
                $inseeDataArray = (array) $data;
                usort($inseeDataArray, function($a, $b) {
                    return strcasecmp($a->title, $b->title);
                });
                $place->data->insee->{$zone}->{$key} = $inseeDataArray;
            }
        }
    }

    protected function sortComposition($composition){
      $compositionArray = (array) $composition;
      $keys = array_keys($compositionArray);
      usort($compositionArray, function($a, $b)
      {
        if ($a->nombre == $b->nombre) {
            return 0;
        }
        return ($a->nombre > $b->nombre) ? -1 : 1;


      });
      return (object)$compositionArray;
    }

}
