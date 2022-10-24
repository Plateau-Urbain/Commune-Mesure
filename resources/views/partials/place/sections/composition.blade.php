<section id="composition" class="content-block">
  <div class="columns">
    <h4 class="title has-text-primary no-border is-uppercase is-hidden-tablet">La composition</h4>
    <p class="is-hidden-tablet">Nombre et nature des structures ayant leurs locaux ou exerçant leur activité au sein du lieu.</p>

    <div class="column is-6 is-flex is-flex-direction-column is-justify-content-center is-align-items-flex-end">
      <div class="is-flex is-flex-direction-column is-align-items-center">
        <svg id="waffle" width="100%" height=500 aria-label="Graphique répartition par structure" role="img"></svg>
        <h6 class="subtitle is-6">Type de structures participant au projet</h6>
      </div>
    </div>

    <div class="column is-5 is-flex is-flex-direction-column is-justify-content-center">
      <h4 class="title has-text-primary no-border is-uppercase is-hidden-mobile">La composition</h4>
      <p class="is-hidden-mobile">Nombre et nature des structures ayant leurs locaux ou exerçant leur activité au sein du lieu.</p>

      <div class="columns mt-2">
        @if (isset($edit) || $place->get('blocs->presentation->donnees->nombre_occupants') > 0)
          <div class="column is-6">
            <span class="is-size-1 has-text-primary has-text-weight-bold">
              {{ $place->get('blocs->presentation->donnees->nombre_occupants') }}
            </span>
            <br/>
            <p>
              {{ $place->get('blocs->presentation->donnees->nombre_occupants') > 1 ? 'structures occupantes' : 'structure occupante' }}
              @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->nombre_occupants','id_section'=>'presentation','type' => 'number','titre'=>"Modifier le nombre de structures occupantes",'description' =>"Le nombre de structures exerçant leur activité ou  ayant leurs  locaux au sein du lieu"])
            </p>
          </div>
        @endif

        @if (isset($edit) || $place->get('blocs->presentation->donnees->structures_crees') > 0)
          <div class="column is-6">
            <span class="is-size-1 has-text-primary has-text-weight-bold">
              {{ $place->get('blocs->composition->donnees->structures_crees') }}
            </span>
            <br/>
            <p>{{ $place->get('blocs->composition->donnees->structures_crees') > 1 ? 'structures créées' : 'structure créée' }}</p>
            @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->nombre_occupants','id_section'=>'presentation','type' => 'number','titre'=>"Modifier le nombre de structures occupantes",'description' =>"Le nombre de structures exerçant leur activité ou  ayant leurs  locaux au sein du lieu"])
          </div>
        @endif
      </div>

      @if(!$place->isEmptyAccessibilityBySection('publics') && !isset($edit) || isset($edit))
        @include('partials.place.sections.public')
      @endif

      @if(!$place->isEmptyAccessibilityBySection('accessibilite')&& !isset($edit) || isset($edit))
        @include('partials.place.sections.accessibilite')
      @endif
    </div>
  </div>
</section>
