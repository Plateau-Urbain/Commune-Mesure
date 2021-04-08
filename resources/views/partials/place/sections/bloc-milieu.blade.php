<div class="home-head">
  <figure class="image">
    <img src="/images/roofing.svg">
  </figure>
</div>
<div class="column home-body">
  <div class="columns is-mobile">
    <div class="column home-body-left">
      <div class="window very-small edit-milieu">{{ $place->get('blocs->presentation->donnees->nombre_occupants') }} structures occupantes @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->nombre_occupants','id_section'=>'section01','type' => 'number','titre'=>"Modifier Le nombre de structures occupantes"])</div>
      <div class="window very-small edit-milieu">La gouvernance partagée avec {{ $place->get('blocs->presentation->donnees->noms_occupants') }} @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->noms_occupants','id_section'=>'section01','type' => 'text','titre'=>"Modifier La gouvernance"])</div>
      <div class="window very-small edit-milieu">Ouvert depuis {{ $place->get('blocs->presentation->donnees->date_ouverture') }} @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->date_ouverture','id_section'=>'section01','type' => 'date','titre'=>"Modifier La date d'ouverture",'description'=>"Quand a été ouvert votre lieu ?"])</div>
      <div class="window very-small edit-milieu">Surface de {{ $place->get('blocs->presentation->donnees->surface') }}m<sup>2</sup>  @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->surface','id_section'=>'section01','type' => 'decimal','titre'=>"Modifier La surface",'description'=>"Quelle est la surface de votre lieu ?"])</div>
      <div class="window very-small edit-milieu">{{ $place->get('blocs->presentation->donnees->etp') }} ETP @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->etp','id_section'=>'section01','type' => 'decimal','titre'=>"Modifier Le nombre d'ETP"])</div>

      <div class="home-door">
        <figure class="image">
          <img src="/images/foot_home.svg">
        </figure>
      </div>
    </div>

    <div class="column is-one-third has-text-centered home-body-right">
    <figure class="image">
          <img src="/images/groupe_windows.svg">
        </figure>
        <figure class="image">
          <img src="/images/groupe_windows.svg">
        </figure>
    </div>
  </div>
</div>
<div class="home-foot"></div>

