<div class="home-head">
  <figure class="image">
    <img src="/images/roofing.svg">
  </figure>
</div>
<div class="column home-body">
  <div class="columns is-mobile">
    <div class="column home-body-left">
      <div class="window very-small edit-milieu">{{ $place->manager->occupants }} structures occupantes @include('components.modals.modalEdition',['chemin'=>'manager->occupants','titre'=>"Modifier Le nombre de structures occupantes"])</div>
      <div class="window very-small edit-milieu">La gouvernance partagée avec {{ $place->manager->name }} @include('components.modals.modalEdition',['chemin'=>'manager->name','titre'=>"Modifier La gouvernance"])</div>
      <div class="window very-small edit-milieu">Ouvert depuis {{ $place->ouverture}} @include('components.modals.modalEdition',['chemin'=>'ouverture','titre'=>"Modifier La date d'ouverture",'description'=>"Quand a été ouvert votre lieu ?"])</div>
      <div class="window very-small edit-milieu">Surface de {{ $place->data->compare->moyens->superficie->nombre}}m<sup>2</sup>  @include('components.modals.modalEdition',['chemin'=>'data->compare->moyens->superficie->nombre','titre'=>"Modifier La surface",'description'=>"Quelle est la surface de votre lieu ?"])</div>
      <div class="window very-small edit-milieu">{{ $place->data->compare->moyens->etp->nombre}} ETP @include('components.modals.modalEdition',['chemin'=>'data->compare->moyens->etp->nombre','titre'=>"Modifier Le nombre d'ETP"])</div>

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

