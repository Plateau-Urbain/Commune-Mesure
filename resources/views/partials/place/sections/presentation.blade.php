<section class="section-place content-block" id="presentation">
  <div class="columns is-relative">
    <div class="is-hidden-tablet column is-flex is-flex-direction-column is-justify-content-center p-5 has-text-centered">
      <h4 class="subtitle is-4 mb-2 pb-3">{{ $place->get('address->city') }}</h4>
      <h1 class="title has-text-primary has-text-weight-normal is-uppercase no-border mb-0">{{ $place->get('name') }}</h1>

      <p class="is-size-5">
        @if (isset($edit) && ! $place->get('blocs->presentation->donnees->punchline'))
            Décrivez votre lieu en une ou deux phrases
        @else
          {{ $place->get('blocs->presentation->donnees->punchline') }}
        @endif
        <span class="icon-edit">
          @include('components.modals.modalEdition', ['chemin' => 'blocs->presentation->donnees->punchline', 'id_section' => 'presentation', 'type' => 'text', 'titre' => "Modifier la punchline", 'description' => "Décrivez votre lieu en quelques mots"])
        </span>
      </p>
      <p class="mt-5">
        @include('partials.place.reseaux-sociaux')
      </p>
    </div>
    <div class="column is-10 is-offset-1">
      <div class="columns">
        <div class="column is-hidden-mobile pt-5">
          @include('partials.place.sections.batiment', ['is_mobile' => 'false'])
        </div>
        <div class="column is-hidden-desktop is-hidden-tablet column is-6 is-offset-1 pt-6">
          @include('partials.place.sections.batiment', ['is_mobile' => 'true'])
        </div>
      </div>
    </div>

    <div id="bloc-2-presentation" class="is-hidden-mobile column is-3 is-flex is-flex-direction-column is-justify-content-center">
      <h4 class="subtitle is-4 mb-2 pb-3">{{ $place->get('address->city') }}</h4>
      <h1 class="title has-text-primary has-text-weight-normal is-uppercase no-border mb-0">{{ $place->get('name') }}</h1>

      <p class="is-size-5">
        @if (isset($edit) && ! $place->get('blocs->presentation->donnees->punchline'))
            Décrivez votre lieu en une ou deux phrases
        @else
          {{ $place->get('blocs->presentation->donnees->punchline') }}
        @endif
        <span class="icon-edit">
          @include('components.modals.modalEdition', ['chemin' => 'blocs->presentation->donnees->punchline', 'id_section' => 'presentation', 'type' => 'text', 'titre' => "Modifier la punchline", 'description' => "Décrivez votre lieu en quelques mots"])
        </span>
      </p>
      <p class="mt-5">
        @include('partials.place.reseaux-sociaux')
      </p>
    </div>
  </div>
</section>

<section class="section-place content-block">
  <div class="columns">
    <div class="column is-9 is-offset-2">
      <div class="columns">
        <div class="column is-6 is-5-widescreen ">
          <div id="bloc-surface"class="mx-auto is-block">
            <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase">
              Surface
              <span class="icon-edit">
                @include('components.modals.modalEdition', ['chemin' => 'blocs->presentation->donnees->surfaces', 'id_section' => 'presentation', 'type' => 'number', 'titre' => "Modifier les surfaces", 'description' => "Modifiez les différentes surfaces de votre lieu"])
              </span>
            </h4>
            <h6 class="subtitle is-4"><span id="graph_superficie__superficie_totale">{{ $place->get('blocs->presentation->donnees->surfaces->totale') }}</span> m² au total</h6>
            <div class="chart-container">
              <svg id="graph_superficie" width="80%" style="max-width: 350px" aria-label="Graphique de la répartition de la superficie" role="img"></svg>
            </div>
          </div>
        </div>

        <div id="div-carousel" class="column is-6 is-7-widescreen">
          @include('partials.place.sections.carousel')
        </div>
      </div>
    </div>
  </div>
</section>
