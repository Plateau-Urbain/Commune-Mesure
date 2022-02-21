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
  <div class="columns is-multiline">
    @foreach($place->get('blocs->valeurs->donnees') as $valeur => $active)
      @if($active)
      <div class="column is-one-third-tablet is-one-quarter-desktop has-text-centered">
        <p><strong class="valeurs has-text-primary">{{$valeur}}</strong></p>
        <p>
          {{ $place->get('blocs->valeurs->texte->'.$valeur) }}
          @include('components.modals.modalEdition', ['chemin' => 'blocs->valeurs->texte->'.$valeur, 'id_section' => 'valeurs', 'type' => 'text', 'titre' => 'Valeur : '.$valeur, 'description' => 'Le texte apparaitera sous la valeur.'])
        </p>
      </div>
      @endif
    @endforeach
  </div>
