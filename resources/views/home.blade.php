@extends('layout')

@section('head_css')
    @parent

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="stylesheet" href="/css/map.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css"/>
@endsection

@section('content')
    <div class="column is-10 is-offset-1">
        <div class="section">
            <div class="hero ">
                <div class="hero-body">
                    <div class="container">
                        <div class="column">
                            <h1 class="title has-text-centered">
                                Le projet
                            </h1>
                            <div class="description">
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
                </div>
            </div>
        </div>
        <div class="section">
            <div class="hero">
                <div class="column">
                    <div class="level">
                        <div class="level-item has-background-dark has-text-centered block-data-stat">
                            <div>
                                <p class="title has-text-white animate-value" id="animate-place" data-total={{ count($coordinates) }}>{{ count($coordinates) }}</p>
                                <p class="heading has-text-white">Les lieux</p>
                            </div>
                        </div>
                        <div class="level-item has-background-dark has-text-centered block-data-stat">
                            <div>
                                <p class="title has-text-white animate-value" id="animate-city" data-total={{ count($cities) }}>{{ count($cities) }}</p>
                                <p class="heading has-text-white">Les villes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="hero column" id="block-map">
                <div id="mapid"></div>
            </div>
        </div>

    </div>
@endsection

@section('script_js')

    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

    <script src="/js/map.js"></script>
    <script src="/js/animate.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js" ></script>
    <script>
        var markersCluster = new L.markerClusterGroup();
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
        map.addLayer(markersCluster);
        var featureGroup = L.featureGroup(groupMarker);
        map.fitBounds(featureGroup.getBounds());
    </script>
@endsection
