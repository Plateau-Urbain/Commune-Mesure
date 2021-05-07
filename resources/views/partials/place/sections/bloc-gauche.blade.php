<div class=" bloc-note">
  <div class="header-bloc-note">
    <figure class="image">
      <img src="/images/Porte_bloc.png">
    </figure>
  </div>
  <div class="bloc-note-body">
    <div class="content">
      <br>
      <h4 class="has-text-centered">L'IDÉE FONDATRICE</h4>
      <br>
      <p class="fontSize1em">{{$place->get('blocs->presentation->donnees->idee_fondatrice')}} @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->idee_fondatrice','id_section'=>'presentation','type' => 'text','titre'=>"Modifier l'idée fondatrice",'description'=>" L'idée autour de laquelle le lieu s'est construit"])
</p>
    </div>
  </div>
</div>
