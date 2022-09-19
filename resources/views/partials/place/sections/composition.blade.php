<section id="composition" class="p-5" style="height: 90vh">
  <div class="columns" style="height: 100%;">
    <div class="column is-6 is-flex is-flex-direction-column is-justify-content-center is-align-items-end">
      <div class="is-flex is-flex-direction-column is-align-items-center">
        <svg id="waffle" width=500 height=500 aria-label="Graphique répartition par structure" role="img"></svg>
        <h6 class="subtitle is-6">Type de structures participant au projet</h6>
      </div>
    </div>

    <div class="column is-4 is-flex is-flex-direction-column is-justify-content-center">
      <h4 class="is-size-4 has-text-primary no-border is-uppercase">La composition</h4>
      <p>Nombre et nature des structures ayant leurs locaux ou exerçant leur activité au sein du lieu.</p>

      <div class="columns mt-2">
        <div class="column is-6">
          <span class="is-size-1 has-text-primary has-text-weight-bold">
            {{ $place->get('blocs->presentation->donnees->nombre_occupants') }}
          </span>
          <br/>
          <p>{{ $place->get('blocs->presentation->donnees->nombre_occupants') > 1 ? 'structures occupantes' : 'structure occupante' }}</p>
          @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->nombre_occupants','id_section'=>'presentation','type' => 'number','titre'=>"Modifier le nombre de structures occupantes",'description' =>"Le nombre de structures exerçant leur activité ou  ayant leurs  locaux au sein du lieu"])
        </div>

        <div class="column is-6">
          <span class="is-size-1 has-text-primary has-text-weight-bold">
            {{ $place->get('blocs->composition->donnees->structures_crees') }}
          </span>
          <br/>
          <p>{{ $place->get('blocs->composition->donnees->structures_crees') > 1 ? 'structures créées' : 'structure créée' }}</p>
          @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->nombre_occupants','id_section'=>'presentation','type' => 'number','titre'=>"Modifier le nombre de structures occupantes",'description' =>"Le nombre de structures exerçant leur activité ou  ayant leurs  locaux au sein du lieu"])
        </div>

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
