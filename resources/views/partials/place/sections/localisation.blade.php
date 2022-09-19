<section class="hero is-medium" id="accessibilite">
  <div class="columns">
    <div class="column is-5 hero-body">
      <div>
        <h4 class="title is-4 has-text-primary no-border is-uppercase">Localisation</h4>

        <p class="has-text-left">
          <a href="geo:{{ $place->get('blocs->data_territoire->donnees->geo->lat') }},{{ $place->get('blocs->data_territoire->donnees->geo->lon') }}">
            {{ $place->get('address->address') }}
          </a>
        </p>
        <p>{{ $place->get('address->postalcode') }} {{ $place->get('address->city') }}</p>

        <div class="mt-5">
          @if(!$place->isEmptyAccessibilityBySection('transports') && !isset($edit) || isset($edit))
            @include('partials.place.sections.transport')
          @endif
        </div>
      </div>
    </div>

    <div class="column is-7">
      <img style="position: absolute; z-index: 435;" src="{{ url('/images/map-mask.png') }}">
      <div id="section-map" class="map-fullwidth"></div>
    </div>
  </div>

  <div class="mx-auto has-text-centered">
    <label>Choississez un découpage géographique: </label>
    <div class="mb-5 control has-icons-left">
      <div class="select">
        <span class="icon is-large is-left">
          <i class="fas fa-map"></i>
        </span>
        <select id="selectGeo">
          <option value="iris" selected>Proximité immédiate</option>
          <option value="commune">Commune</option>
          <option value="departement">Département</option>
          <option value="region">Région</option>
        </select>
      </div>
    </div>
    <h3 class="title is-5 no-border is-uppercase mb-0">Population</h3>
    <svg id="population-chart" class="mb-5"></svg>
    <h3 class="title is-5 no-border is-uppercase mb-0">Catégories Socioprofessionelles</h3>
    <svg id="csp-chart"></svg>
    <h3 class="title is-5 no-border is-uppercase mb-0">Immobilier</h3>
    <svg id="immobilier-chart"></svg>
  </div>

</section>

