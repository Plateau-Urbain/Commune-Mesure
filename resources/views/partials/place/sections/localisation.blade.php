<section id="accessibilite" class="content-block">
  <div class="columns">
    <div class="column is-8-desktop is-offset-2-desktop">
      <div class="columns">
        <div class="column is-4 is-flex">
          <div>
            <h4 class="title has-text-primary no-border has-text-weight-normal has-text-weight-normal is-uppercase">Localisation</h4>

            <p class="has-text-left is-size-5">
              <a id="lien-adresse" href="geo:{{ $place->get('blocs->data_territoire->donnees->geo->lat') }},{{ $place->get('blocs->data_territoire->donnees->geo->lon') }}">
                {{ str_replace(",", ",\n",$place->get('address->address')) }} </br>
                {{ $place->get('address->postalcode') }} </br>
                {{ $place->get('address->city') }}<br>
              </a>
              @if(isset($edit))
                @include('components.modals.modalAddressEdition', ['id_section' => 'accessibilite', 'titre' => "Modifier l'adresse du lieu", "description" => "Modifier l'adresse du lieu"])
              @endif
            </p>
            <div class="mt-5">
              @if(!$place->isEmptyAccessibilityBySection('transports') && !isset($edit) || isset($edit))
                @include('partials.place.sections.transport')
              @endif
            </div>
          </div>
        </div>

        <div class="column is-8">
          <div id="section-map" class="map-fullwidth mask"></div>
          @if(isset($edit))
          @include('components.modals.modalLatLonEdition', ['id_section' => 'accessibilite', 'titre' => "Modifier les coordonnées du lieu", "description" => "Modifier les coordonnées du lieu"])
        @endif
        </div>
      </div>

      <div id="charts-insee" class="mx-auto has-text-centered" style="padding-top:50px">
        <h3 class="title is-5 no-border is-uppercase mb-0 is-hidden">Population</h3>
        <svg id="population-chart" width="100%" height="250"></svg>
        <h3 class="title is-5 no-border is-uppercase mb-0 is-hidden">Catégories Socioprofessionelles</h3>
        <svg id="csp-chart" width="100%" height="250"></svg>
        <h3 class="title is-5 no-border is-uppercase mb-0 is-hidden">Immobilier</h3>
        <svg id="immobilier-chart" width="100%" height="250"></svg>
      </div>
    </div>
  </div>
</section>
