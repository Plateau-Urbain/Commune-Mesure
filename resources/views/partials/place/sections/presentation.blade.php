<section class="section-place fond-bleu" id="presentation">
  <div class="columns is-relative">
    <div id="pavement-top" style="position: absolute; display: none; height: 5px; background: #262631; width: 90%; left: 5%;"></div>
    <div id="pavement-bottom" style="position: absolute; display: none; height: 2px; background: #262631; width: 90%; left: 5%;"></div>
    <div class="is-hidden-tablet column is-flex is-flex-direction-column is-justify-content-center p-5 has-text-centered">
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

      <div class="has-text-centered mt-4 is-relative">

        <x-svg :path="'assets/images/batiment/'.$batiment->getToit('gauche').'.svg'" class="is-block" transform="" width="100%" height="240" />

        @for ($i = 0; $i < 3; $i++)
          <svg height="240" class="is-block mx-auto" style="z-index: 100; position: relative;">
            @php $t = $batiment->getThematique($i); @endphp
            @php $part = (strpos($t, 'THEME_') === false) ? 'THEME_VIERGE' : $t; @endphp
            <x-svg :path="'assets/images/batiment/themes/'.$part.'.svg'" class="" transform="" width="100%" height="100%">

              @if (strpos($t, 'THEME_') === false)
                @if (mb_strlen($t) > 30)
                  <text x="50%" dominant-baseline="middle" text-anchor="middle" style="font-size:3rem;font-weight:bold;fill:#c9514a;">
                  <tspan x="50%" dy="-1.2em">{{ strtok(mb_strtoupper($t), ' ') }} {{ strtok(' ') }} {{ strtok(' ') }}</tspan>
                  @while($text = strtok(' '))
                    <tspan x="50%" dy="1.2em">{{ $text }} {{ strtok(' ') }} {{ strtok(' ') }}</tspan>
                  @endwhile
                  </text>
                @else
                  <text x="50%" dominant-baseline="middle" text-anchor="middle" style="font-size:3rem;font-weight:bold;fill:#c9514a;" >
                    {{ mb_strtoupper($t) }}
                  </text>
                @endif
              @endif

            </x-svg>
          </svg>
        @endfor
        <div style="position: absolute; bottom: 16px; height: 3px; background: #262631; width: 90%; left: 5%;"></div>
        <div style="position: absolute; bottom: 2px; height: 1px; background: #262631; width: 90%; left: 5%;"></div>
      </div>

    </div>
    <div class="is-hidden-mobile column is-6 is-offset-1">
      @include('partials.place.sections.batiment')
    </div>

    <div class="is-hidden-mobile column is-4 is-flex is-flex-direction-column is-justify-content-center">
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
