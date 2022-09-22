<section class="section-place fond-bleu" id="presentation">
  <div class="columns">
    <div class="column">
      @include('partials.place.sections.batiment')
    </div>

    <div class="column is-4 is-flex is-flex-direction-column is-justify-content-center">
      <h4 class="subtitle is-6">{{ $place->get('address->city') }}</h4>
      <h1 class="title has-text-primary is-2 no-border mb-0">{{ $place->get('name') }}</h1>

      <p class="is-size-5">
        @if (isset($edit))
          @if ($place->get('blocs->presentation->donnees->punchline'))
            {{ $place->get('blocs->presentation->donnees->punchline') }}
          @else
            Décrivez votre lieu en une ou deux phrases
          @endif
        @else
          {{ $place->get('blocs->presentation->donnees->punchline') }}
        @endif
        <span class="icon-edit">
          @include('components.modals.modalEdition', ['chemin' => 'blocs->presentation->donnees->punchline', 'id_section' => 'presentation', 'type' => 'text', 'titre' => "Modifier la punchline", 'description' => "Décrivez votre lieu en quelques mots"])
        </span>
      </p>
      <p class="mt-6">
        @include('partials.place.reseaux-sociaux')
      </p>

    </div>
  </div>
</section>

<section class="section-place fond-bleu pt-5">
  <div class="columns">
    <div class="column is-6">
      <div class="mx-auto is-block has-text-centered">
        <h4 class="title has-text-primary no-border is-uppercase">Surface</h4>
        <h6 class="subtitle">{{ $place->get('blocs->presentation->donnees->surfaces->totale') }}m² au total</h6>
        <div class="chart-container">
          <svg id="graph_superficie" width=500 height=500 aria-label="Graphique de la répartition de la superficie" role="img"></svg>
        </div>
      </div>
    </div>

    <div class="column is-6">
      @include('partials.place.sections.carousel')
    </div>
  </div>
</section>
