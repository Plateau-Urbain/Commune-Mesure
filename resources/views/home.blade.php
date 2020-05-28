@extends('layout')

@section('head_css')
    @parent

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="stylesheet" href="/css/map.css">
@endsection

@section('content')
    <div class="section column is-four-fifths is-offset-1">
        <div class="hero ">
            <div class="hero-body">
                <div class="container">
                    <div class="column is-fifths is-offset-two-four">
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


    <div class="hero is-dark" id="block-data-stat">
        <div class="columns">
            <div class="column">
                <span>
                    <img src="/images/visualization.svg" style="height: 25em">
                </span>
            </div>
            <div class="column">
                <span>
                <img src="/images/visualization2.svg">
                </span>
            </div>
        </div>
    </div>

    <div class="hero column is-four-fifths is-offset-1" id="block-map">
        <div id="mapid"></div>

    </div>
    </div>
@endsection

@section('script_js')
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

    <script src="/js/map.js"></script>
    <script>
        @foreach ($coordinates as $name => $place)
        L.marker([{{ $place['geo']->lat }}, {{ $place['geo']->lon}}]).bindPopup("{!! $place['popup'] !!}").addTo(map)
        @endforeach
    </script>
@endsection
