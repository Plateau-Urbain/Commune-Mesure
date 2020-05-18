@extends('layout')

@section('head_css')
    @parent

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="stylesheet" href="/css/map.css">
@endsection

@section('content')
    <div id="mapid"></div>
    <div id="info-panel"></div>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

    <script src="/js/map.js"></script>
    <script>
        @foreach ($coordinates as $name => $place)
            L.marker([{{ $place['geo']->lat }}, {{ $place['geo']->lon}}]).bindPopup("{!! $place['popup'] !!}").addTo(map)
        @endforeach
    </script>
@endsection
