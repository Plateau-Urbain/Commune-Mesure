<div class="banner-image-and-fil">
  <div class="banner-image">
    <img src="{{ url('/images/Les_valeurs.png') }}">
  </div>
  <div class="banner-fil fil-4">
    <div>
    <h2 class="sous-banner has-image-attached">Les valeurs portées
      <span class="icon-edit">
        @include('components.modals.modalEdition',['chemin'=>"blocs->valeurs->donnees", 'id_section'=>'valeurs','type' => 'checkbox','titre' => 'Modifier les 3 valeurs fondamentales de votre lieu','description'=>"Les valeurs fondamentales autour desquelles le projet du lieu s'est construit"])
      </span>
    </h2>
  </div>
  </div>
  <p class='description-section'>Les valeurs fondamentales autour desquelles le projet du lieu s'est construit</p>
</div>
<br>
<div class="columns">
    @foreach($place->get('blocs->valeurs->donnees') as $valeur => $tabExemples)
      @if($tabExemples)
      <div class="column">
        <p class="has-text-centered">
          <strong class="valeurs">{{$valeur}}</strong>
        <p>
      </div>
      @endif
    @endforeach

</div>
