<div class="home-head">
  <figure class="image">
    <img src="{{ url('/images/roofing.svg') }}">
  </figure>
</div>
<div class="column home-body">
  <div class="columns is-mobile">
    <div class="column home-body-left">
      <div class="window very-small edit-milieu">{{ $place->get('blocs->presentation->donnees->nombre_occupants') }} structures occupantes @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->nombre_occupants','id_section'=>'presentation','type' => 'number','titre'=>"Modifier le nombre de structures occupantes",'description' =>"Le nombre de structures exerçant leur activité ou  ayant leurs  locaux au sein du lieu"])</div>
      <div class="window very-small edit-milieu">La gouvernance partagée avec {{ $place->get('blocs->presentation->donnees->noms_occupants') }} @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->noms_occupants','id_section'=>'presentation','type' => 'text','titre'=>"Modifier la gouvernance partagée","description" =>"Les différentes structures impliquées en cas de gouvernance partagée du lieu "])</div>
      <div class="window very-small edit-milieu">
        @php $date = \Carbon\Carbon::create($place->get('blocs->presentation->donnees->date_ouverture')) @endphp
        @php $now = \Carbon\Carbon::now(); @endphp
        @if ($date < $now) Ouvert depuis le @else Ouverture prévue le @endif
        {{ \Carbon\Carbon::create($place->get('blocs->presentation->donnees->date_ouverture'))->locale(config('app.locale'))->isoFormat("LL") }}
        @include('components.modals.modalEdition', ['chemin' => 'blocs->presentation->donnees->date_ouverture', 'id_section' => 'presentation', 'type' => 'date', 'titre' => "Modifier la date d'ouverture", 'description'=>"La date d'ouverture du lieu"])
      </div>
      <div class="window very-small edit-milieu">Surface de {{ $place->get('blocs->presentation->donnees->surface') }}m<sup>2</sup>  @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->surface','id_section'=>'presentation','type' => 'decimal','titre'=>"Modifier la surface",'description'=>"La superficie du lieu en m2"])</div>
      <div class="window very-small edit-milieu">{{ $place->get('blocs->presentation->donnees->emplois directs') }}
        @if ($place->get('blocs->presentation->donnees->emplois directs') > 1)
          emplois directs
        @else
          emploi direct
        @endif
        @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->emplois directs','id_section'=>'presentation','type' => 'decimal','titre'=>"Modifier le nombre d'emplois directs","description"=>"Nombre d'emplois directement créés par le lieu pour son fonctionnement"])</div>
      <div class="home-door">
        <figure class="image">
          <img src="{{ url('/images/foot_home.svg') }}">
        </figure>
      </div>
    </div>

    <div class="column is-one-third has-text-centered home-body-right">
    <figure class="image">
          <img src="{{ url('/images/groupe_windows.svg') }}">
        </figure>
        <figure class="image">
          <img src="{{ url('/images/groupe_windows.svg') }}">
        </figure>
    </div>
  </div>
</div>
<div class="home-foot"></div>
