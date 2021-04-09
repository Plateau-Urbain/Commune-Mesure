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

        $sections = $place->getVisibility();
        $isEmpty = $place->getIsEmpty();
        $this->sortDataInsee($place->getData());

        return view('place.show', compact('place', 'sections','isEmpty'));
    }

    public function list(Place $place, $sortBy = null)
    {
        $places = $place->retrivePlaces();

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

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

        $sections = $place->getVisibility();
        $isEmpty = $place->getIsEmpty();
        $this->sortDataInsee($place->getData());


        // Pour indiquer à la vue que c'est en mode édition
        $edit = true;


        return view('place.show', compact('place', 'auth', 'slug', 'edit', 'sections','isEmpty'));
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

        $v = $place->toggleVisibility($section);
        $place->set('blocs->'.$section.'->visible',$v);
        $res = $place->save();

        $flash = ['success' => $res, 'section' => $section];
        return redirect(route('place.edit', compact('slug', 'auth')).'#'.$section);
    }

    public function update(Request $request,$slug,$auth,$id_section){
       $place = Place::find($slug);
       if ($place->check($auth) === false) {
         abort(403, 'Wrong authentication string');
       }
       if ($auth === str_repeat('a', 64)) {
           throw new \LogicException('Exiting, default admin hash');
       }

       if (is_array($place->get($request->chemin)) && isset($request->type) && $request->type == "text"){   // plusieurs champs textuel dans le modal

         $tab = $place->get($request->chemin);
         $i=0;
         foreach($tab as $champ){
           $place->setOnArray(($request->chemin),array_search($champ,$tab), $request->{'champ'.$i});
           $i++;
         }
         if($request->{'champ'.$i}!=""){
           $place->setOnArray(($request->chemin),$i,$request->{'champ'.$i});
         }
         $j=$i+1;
         if($request->{'champ'.$j}!="" && $request->{'champ'.$i} == ""){
           $place->setOnArray(($request->chemin),$i,$request->{'champ'.$j});
         }
         if($request->{'champ'.$j}!="" && $request->{'champ'.$i} != ""){
           $place->setOnArray(($request->chemin),$j,$request->{'champ'.$j});
         }
         $place->set($request->chemin,array_values(array_filter($place->get($request->chemin))));
         $place->save();
         return redirect(route('place.edit', compact('slug', 'auth')).'#'.$id_section);
       }


       if ( is_object($place->get($request->chemin)) && isset($request->type) && $request->type == "checkbox"){
         $i=0;
         foreach($place->get($request->chemin) as $value => $check) {
           if($request->{$i} == "on"){
             $on = 1;
           }
           else{
             $on = 0;
           }
           $place->get($request->chemin)->{$value} = $on;
           $place->save();
           $i++;
         }
         return redirect(route('place.edit', compact('slug', 'auth')).'#'.$id_section);
       }
       if ( is_object($place->get($request->chemin)) && isset($request->type) && $request->type == "number"){
         $i=0;
         foreach($place->get($request->chemin) as $k => $v) {
           $place->get($request->chemin)->{$k} = $request->{$i};
           $place->save();
           $i++;
         }
         return redirect(route('place.edit', compact('slug', 'auth')).'#'.$id_section);
       }

       if(empty($request->champ) && $request->type == "number"){
         $new = 0;
       }
       else{
         $new = $request->champ;
       }
       $place->set($request->chemin,$new);

       $place->save();

       return redirect(route('place.edit', compact('slug', 'auth')).'#'.$id_section);
    }

    public function editGalerie($slug,$auth){
      $place = Place::find($slug);
      $auths = $place->getAuth();
      $sections = $place->getVisibility();
      $isEmpty = $place->getIsEmpty();

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
      return view('components.modals.modalEditionGalerie',compact('place', 'slug','auth','edit','chemin','auths','sections','isEmpty'));
    }


    public function updateGalerie(Request $request,$slug,$auth){
        $place = Place::find($slug);
        $auths = $place->getAuth();
        $sections = $place->getVisibility();
        $isEmpty = $place->getIsEmpty();

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

        if(isset($_POST['supprimer']) && ctype_digit($_POST['supprimer'])){
          $place->deletePhoto($_POST['supprimer']);
          $place->save();
          return redirect(route('place.editGalerie',compact('place', 'slug','auth','edit','chemin','auths','sections')));
        }
        if(isset($_POST['ajouter']) && $_POST['ajouter']=="ajouter"){
          if( (!in_array( get_extension($_FILES['image']['name']), $extensions)))
          {
            // echo("Ce n'est pas une image");
            return view('components.modals.modalEditionGalerie',compact('place', 'slug','auth','edit','chemin','auths','sections'));
          }
          if( file_exists($_FILES['image']['tmp_name']) and filesize($_FILES['image']['tmp_name']) > 3027*3072){
            // echo("Pas la bonne taille");
            return view('components.modals.modalEditionGalerie',compact('place', 'slug','auth','edit','chemin','auths','sections'));
          }

          $name=$_FILES['image']['name'];
          $dossier = '../public/images/lieux/';
          move_uploaded_file( $_FILES['image']['tmp_name'], $dossier . basename($_FILES['image']['name']));

          $place->addPhoto($name);
          $place->save();

          return redirect(route('place.editGalerie',compact('place', 'slug','auth','edit','chemin','auths','sections')));
        }
        else{
          return view('place.show', compact('place', 'auth', 'slug', 'edit', 'sections','isEmpty'));
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
        $insee = $place->blocs->data_territoire->donnees->insee;
        foreach ($insee as $zone => $datas) {
            foreach ($datas as $key => $data) {
                $inseeDataArray = (array) $data;
                usort($inseeDataArray, function($a, $b) {
                    return strcasecmp($a->title, $b->title);
                });
                $place->blocs->data_territoire->donnees->insee->{$zone}->{$key} = $inseeDataArray;
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
