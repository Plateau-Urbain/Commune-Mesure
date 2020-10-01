@extends('layout')

@section('head_css')
    @parent

    <link rel="stylesheet" href="/css/map.css">
@endsection

@section('content')
    <div class="container section">
        <div class="content">
            <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                type and scrambled it to make a type specimen book. It has survived not only five centuries, but
                also the leap into electronic typesetting, remaining essentially unchanged. It was popularised
                in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more
                recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
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
                <h1 class="title is-2">Titre</h1>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                    the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has survived not only five centuries, but
                    also the leap into electronic typesetting, remaining essentially unchanged. It was popularised
                    in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more
                    recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </p>
            </div>
            <div class="column">
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                    the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type specimen book. It has survived not only five centuries, but
                    also the leap into electronic typesetting, remaining essentially unchanged. It was popularised
                    in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more
                    recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
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
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                        type and scrambled it to make a type specimen book. It has survived not only five centuries, but
                        also the leap into electronic typesetting, remaining essentially unchanged. It was popularised
                        in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more
                        recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    </p>
                </div>
                <div class="column">
                    <img class=" is-pulled-right" src="https://fakeimg.pl/450x350/">
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
