<section id="accessibilite">
  <div class="columns">
    <div class="column is-5 is-flex is-align-self-center is-justify-content-end">
      <div>
        <h4 class="title has-text-primary no-border is-uppercase">Localisation</h4>

        <p class="has-text-left is-size-5">
          <a href="geo:{{ $place->get('blocs->data_territoire->donnees->geo->lat') }},{{ $place->get('blocs->data_territoire->donnees->geo->lon') }}">
            {{ $place->get('address->address') }}
          </a>
        </p>
        <p class="is-size-5">{{ $place->get('address->postalcode') }} {{ $place->get('address->city') }}</p>

        <div class="mt-5">
          @if(!$place->isEmptyAccessibilityBySection('transports') && !isset($edit) || isset($edit))
            @include('partials.place.sections.transport')
          @endif
        </div>
      </div>
    </div>

    <div class="column is-7">
      <div id="section-map" class="map-fullwidth mask"></div>
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
    <h3 class="title is-5 no-border is-uppercase mb-0 is-hidden">Population</h3>
    <svg id="population-chart" class="mb-5" width="80%" height="30vh"></svg>
    <h3 class="title is-5 no-border is-uppercase mb-0 is-hidden">Catégories Socioprofessionelles</h3>
    <svg id="csp-chart" width="80%" height="30vh"></svg>
    <h3 class="title is-5 no-border is-uppercase mb-0 is-hidden">Immobilier</h3>
    <svg id="immobilier-chart" width="80%" height="30vh"></svg>
  </div>

</section>

