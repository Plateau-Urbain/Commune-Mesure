<div class="home-head">
  <figure class="image">
    <img src="/images/roofing.svg">
  </figure>
</div>
<div class="column home-body">
  <div class="columns is-mobile">
    <div class="column home-body-left">
      <div class="window very-small">{{ $place->manager->occupants }} structures occupantes @include('components.modals.modalEdition',['chemin'=>'manager->occupants'])</div>
      <div class="window very-small">La gouvernance partagée avec {{ $place->manager->name }} @include('components.modals.modalEdition',['chemin'=>'manager->name'])</div>
      <div class="window very-small">Ouvert depuis {{ $place->ouverture}} @include('components.modals.modalEdition',['chemin'=>'ouverture'])</div>
      <div class="window very-small">Surface de {{ $place->data->compare->moyens->superficie->nombre}}m<sup>2</sup>  @include('components.modals.modalEdition',['chemin'=>'data->compare->moyens->superficie->nombre'])</div>
      <div class="window very-small">{{ $place->data->compare->moyens->etp->nombre}} ETP @include('components.modals.modalEdition',['chemin'=>'data->compare->moyens->etp->nombre'])</div>

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

