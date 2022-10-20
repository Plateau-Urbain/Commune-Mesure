<section class="section-place fond-bleu" id="presentation">
  <div class="columns">
    <div class="is-hidden-desktop column is-flex is-flex-direction-column is-justify-content-center p-5">
      <h4 class="subtitle is-6">{{ $place->get('address->city') }}</h4>
      <h1 class="title has-text-primary is-2 no-border mb-0">{{ $place->get('name') }}</h1>

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
      <p class="mt-6">
        @include('partials.place.reseaux-sociaux')
      </p>

      <div class="has-text-centered mt-4">
        @for ($i = 0; $i < 3; $i++)
          <svg height=240>
            @php $t = $batiment->getThematique($i); @endphp
            @php $part = (strpos($t, 'THEME_') === false) ? 'THEME_VIERGE' : $t; @endphp
            <x-svg :path="'assets/images/batiment/themes/'.$part.'.svg'" class="" transform="" width="" height="" />
            @if (strpos($t, 'THEME_') === false)
            <text
               xml:space="preserve"
               id="text24635"
               transform="translate(130,28)"
               style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:0.75rem;line-height:20.4545px;font-family:sans-serif;-inkscape-font-specification:'sans-serif, Bold';font-variant-ligatures:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-east-asian:normal;text-align:center;letter-spacing:0px;word-spacing:0px;writing-mode:lr-tb;white-space:pre;shape-inside:url(#rect24637);fill:#c9514a;fill-opacity:1;stroke:none;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1;text-anchor:middle" >
               {{ mb_strtoupper($t) }}</text>
            @endif
          </svg>
        @endfor
      </div>

    </div>

    <div class="is-hidden-touch column">
      @include('partials.place.sections.batiment')
    </div>

    <div class="is-hidden-touch column is-4 is-flex is-flex-direction-column is-justify-content-center">
      <h4 class="subtitle is-6">{{ $place->get('address->city') }}</h4>
      <h1 class="title has-text-primary is-2 no-border mb-0">{{ $place->get('name') }}</h1>

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
        <h4 class="title has-text-primary no-border is-uppercase">
          Surface
          <span class="icon-edit">
            @include('components.modals.modalEdition', ['chemin' => 'blocs->presentation->donnees->surfaces', 'id_section' => 'presentation', 'type' => 'number', 'titre' => "Modifier les surfaces", 'description' => "Modifiez les différentes surfaces de votre lieu"])
          </span>
        </h4>
        <h6 class="subtitle"><span id="graph_superficie__superficie_totale">{{ $place->get('blocs->presentation->donnees->surfaces->totale') }}</span>m² au total</h6>
        <div class="chart-container">
          <svg id="graph_superficie" width="80%" height="500" aria-label="Graphique de la répartition de la superficie" role="img"></svg>
        </div>
      </div>
    </div>

    <div class="column is-6">
      @include('partials.place.sections.carousel')
    </div>
  </div>
</section>
