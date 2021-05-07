@extends('layout')

@section('head_css')
    @parent

    <link rel="stylesheet" href="/css/map.css">
@endsection

@section('content')
    <div class="container section">
        <div class="content has-text-centered">
            <p class='is-size-4'>
              Les lieux et leurs impacts
            </p>
        </div>
    </div>
    <div class="hero is-primary-light">
        <div class="section">
            <h1 class="title has-text-centered">Les lieux hybrides en chiffres</h1>
            <div class="level block-data-stat">
                <div class="level-item level-item-home has-text-centered">
                    <div>
                        <p class="title animate-value is-1" id="animate-place" data-total={{ count($coordinates) }}>{{ str_replace(","," ",number_format(count($coordinates))) }}</p>
                        <p class="heading title is-4">Lieux</p>
                    </div>
                </div>
                <div class="level-item level-item-home has-text-centered">
                    <div>
                        <p class="title animate-value is-1" id="animate-city" data-total={{ $stats['cities'] }}>{{ str_replace(","," ",number_format($stats['cities'])) }}</p>
                        <p class="heading title is-4">Communes</p>
                    </div>
                </div>
                <div class="level-item level-item-home has-text-centered">
                    <div>
                        <p class="title animate-value is-1" id="animate-meters" data-total={{ $stats['surface'] }}>{{ str_replace(","," ",number_format($stats['surface'])) }}</p>
                        <p class="heading title is-4">m<sup>2</sup></p>
                    </div>
                </div>
                <div class="level-item level-item-home has-text-centered">
                    <div>
                        <p class="title animate-value is-1" id="animate-emplois directs" data-total={{ $stats['emplois directs'] }}>{{ str_replace(","," ",number_format($stats['emplois directs'])) }}</p>
                        <p class="heading title is-4">Emplois</p>
                        <p class="heading title is-4">directs</p>
                    </div>
                </div>
                <div class="level-item level-item-home has-text-centered">
                    <div>
                        <p class="title animate-value is-1" id="animate-events" data-total={{ $stats['evenements'] }}>{{ str_replace(","," ",number_format($stats['evenements'])) }}</p>
                        <p class="heading title is-4">Événements</p>
                        <p class="heading title is-4">organisés</p>
                    </div>
                </div>
                <div class="level-item level-item-home has-text-centered">
                    <div>
                        <p class="title animate-value is-1" id="animate-personnes accueillies" data-total={{ $stats['personnes accueillies'] }}>{{ str_replace(","," ",number_format($stats['personnes accueillies'])) }}</p>
                        <p class="heading title is-4">Personnes</p>
                        <p class="heading title is-4">accueillies</p>
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
                      Montrer le caractère innovant de ces lieux tant au niveau des solutions qu’ils apportent que sur le modèle
                      économique.
                    </p>
                    <p class="accueil-paragraphe">
                      Aider les porteurs.euses de projets à qualifier et valoriser les impacts de leur action sur le plan
                      économique, social, urbain et environnemental pour ajuster leur action au plus près des besoins et
                      mieux cibler les partenaires privés et publics susceptibles de les accompagner.
                    </p>
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

        @foreach($coordinates as $name => $points)
            var point = [{{ $points['geo']['lat'] }}, {{ $points['geo']['lon'] }}];
            @php
            $popupview = str_replace(["\r\n", "\n", '  '], '',
            view('components/popup',
            ['name' => $popup[$name]['name'],
            'title'=>$popup[$name]['title'],
            'description'=>$popup[$name]['description'],
            'departement' => $popup[$name]['departement'],
            'city' => $popup[$name]['city'],
            'images' => $popup[$name]['images']
            ])->render());
            @endphp
            var marker = L.marker(point, {icon: markerIcon}).bindPopup("{!! $popupview !!}");
            groupMarker.push(marker);
            markersCluster.addLayer(marker);
        @endforeach
        homemap.addLayer(markersCluster);
        var featureGroup = L.featureGroup(groupMarker);
        homemap.fitBounds(featureGroup.getBounds());
    </script>
@endsection
