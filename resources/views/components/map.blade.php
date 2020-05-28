@extends('layout')

@section('head_css')
    @parent

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="stylesheet" href="/css/map.css">
@endsection

@section('content')
    <div class="columns">
            <div class="column">
                <div class="hero">
                        <div class="hero-body">
                            <div id="mapid"></div>
                    </div>
                </div>
            </div>
    @if(!is_null($place))
            @include("components.popup-details")
    </div>
            @include("components.evaluation-process")
    @endif
        </div>
        <div class="hero is-dark is-fullheight">
            <div class="hero-body">
                <div class="container impacts">
                    <h1 class="title">
                        Impacts
                    </h1>
                    <h2 class="subtitle">
                        Fullheight subtitle
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

    <script src="/js/map.js"></script>
    <script>
        @foreach ($coordinates as $name => $place)
            L.marker([{{ $place['geo']->lat }}, {{ $place['geo']->lon}}]).bindPopup("{!! $place['popup'] !!}").addTo(map)
        @endforeach
    </script>
@endsection
