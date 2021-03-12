<div class=" bloc-note">
  <div class="header-bloc-note">
    <figure class="image">
      <img src="/images/bloc_noteAsset.png">
    </figure>
  </div>
  <div class="bloc-note-body">
    <div class="content">
      <h2 class="has-text-centered">L'idée fondatrice</h2>
      <p class="fontSize0-8em">{{$place->get('blocs->presentation->donnees->idee_fondatrice')}} @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->idee_fondatrice','type' => 'text','titre'=>"Modifier L'idée Fondatrice",'description'=>"Dites comment le lieu a été fondé."])
</p>
    </div>
  </div>
</div>
