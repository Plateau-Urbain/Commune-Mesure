@extends('layout')

@section('head_css')
    @parent

    <link rel="stylesheet" href="/css/map.css">
@endsection

@section('content')
    <div class="container section">
        <div class="content has-text-centered">
            <p>
              Un outil en commun pour révéler leurs impacts sur les personnes et les territoires
            </p>
        </div>
    </div>
    <div class="hero is-primary-light">
        <div class="section">
            <h1 class="title has-text-centered">Quelques chiffres</h1>
            <div class="level block-data-stat">
                <div class="level-item has-text-centered">
                    <div>
                        <p class="title animate-value is-1" id="animate-place" data-total={{ count($coordinates) }}>{{ count($coordinates) }}</p>
                        <p class="heading title is-4">Lieux</p>
                    </div>
                </div>
                <div class="level-item has-text-centered">
                    <div>
                        <p class="title animate-value is-1" id="animate-city" data-total={{ count($cities) }}>{{ count($cities) }}</p>
                        <p class="heading title is-4">Villes</p>
                    </div>
                </div>
                <div class="level-item has-text-centered">
                    <div>
                        <p class="title animate-value is-1" id="animate-meters" data-total={{ $totalmeters }}>{{ $totalmeters }}</p>
                        <p class="heading title is-4">m<sup>2</sup></p>
                    </div>
                </div>
                <div class="level-item has-text-centered">
                    <div>                      
                        <p class="title animate-value is-1" id="animate-etp" data-total={{ $total_etp }}>{{ $total_etp }}</p>
                        <p class="heading title is-4">ETP</p>
                    </div>
                </div>
                <div class="level-item has-text-centered">
                    <div>
                        <p class="title animate-value is-1" id="animate-events" data-total={{ $total_events }}>{{ $total_events }}</p>
                        <p class="heading title is-4">ÉVÉNEMENTS</p>
                    </div>
                </div>
                <div class="level-item has-text-centered">
                    <div>
                        <p class="title animate-value is-1" id="animate-visiteurs" data-total={{ $total_visiteurs }}>{{ $total_visiteurs }}</p>
                        <p class="heading title is-4">VISITEURS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container section">
        <div class="columns">
            <div class="column">
                <p class="accueil-paragraphe">
                  <strong style="font-size:2em">D</strong>epuis quelques années, des lieux hybrides, par la multiplicité des usages qu’ils proposent et par la
                  diversité des profils qu’ils accueillent, se développent sur tout le territoire français.</p>
                  <p class="accueil-paragraphe">Souvent dénommés « tiers-lieux », ces projets s’inscrivent en marge du processus classique de
                  production immobilière, affirmant une forte vocation culturelle, sociale et écologique.</p>
                  <p class="accueil-paragraphe">La particularité de ces lieux est qu’ils sont, pour la majorité d’entre eux, portés par des personnes
                  guidées par la volonté de créer :
                </p>
            </div>
            <div class="column">
                <p class="accueil-paragraphe">
                  <ul class="" style="padding:10px">
                    <li><strong>Des espaces propices à l’échange et à la mise en commun</strong></li>
                    <li><strong>D’expérimenter ou de restaurer des usages et fonctions urbaines utiles à la population</strong></li>
                    <li><strong>De générer un écosystème en capacité de penser et coconstruire le futur d’une société en pleine transformation</strong></li>
                  </ul>
                </p>
                <p class="accueil-paragraphe">
                  Répondant à des enjeux de développement territorial, de lien social et de solidarité, les lieux hybrides
                  sont vecteurs de bien(s) commun(s) et d’externalités positives reconnus par les usager.e.s,
                  l’environnement proche et bien sûr les actrices et acteurs publiques.
                </p>
            </div>
        </div>
    </div>
    <div class="hero">
        <div class="section" id="block-map">
            <h1 class="title has-text-centered">L'ensemble des lieux</h1>
            <div id="mapid"></div>
        </div>
    </div>
    <div class="container">
        <div class="section">
            <div class="columns">
                <div class="column">
                    <h1 class="title">
                        Le projet
                    </h1>
                    <p class="accueil-paragraphe">
                      La raison d’être du projet « Commune Mesure » est de mettre en lumière les externalités positives de
                      ces lieux hybrides pour :
                    </p>
                    <p class="accueil-paragraphe">
                      Montrer le caractère innovant de ces lieux tant au niveau des solutions qu’ils apportent que sur le model
                      économique.
                    </p>
                    <p class="accueil-paragraphe">
                      Aider les porteurs.euses de projets à qualifier et valoriser les impacts de leur action sur le plan
                      économique, social, urbain et environnemental pour ajuster leur action au plus près des besoins et
                      mieux cibler les partenaires privés et publics susceptibles de les accompagner.
                    </p>
                </div>
                <div class="column">
                    <img class="is-pulled-right" style="height:30%;width:40%" src="{{ url('/images/logos/commune-mesure.png') }}">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script_js')
    @parent
    <script>
        var homemap = mapjs.create('mapid', {gestureHandling: true})
        var markersCluster = L.markerClusterGroup();
        var groupMarker = [];
        var markerIcon = L.divIcon({
            className: 'leaflet-marker-icon leaflet-zoom-animated leaflet-interactive marker-icon-custom',
            html: "<div><span>1</span></div>",
            iconSize: [40, 40],
        });
        @foreach ($coordinates as $name => $place)
            var point = [{{ $place['geo']->lat }}, {{ $place['geo']->lon}}];
            var marker = L.marker(point, {icon: markerIcon}).bindPopup("{!! $place['popup'] !!}");
            groupMarker.push(marker);
            markersCluster.addLayer(marker);
        @endforeach
        homemap.addLayer(markersCluster);
        var featureGroup = L.featureGroup(groupMarker);
        homemap.fitBounds(featureGroup.getBounds());
    </script>
@endsection
