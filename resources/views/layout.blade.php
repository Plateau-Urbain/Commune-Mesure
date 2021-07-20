<!DOCTYPE html>
<html @yield('fixed-navbar', 'class=has-navbar-fixed-top')>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Commune Mesure</title>
        <link rel="shortcut icon" href="{{ url('/images/logos/commune-mesure-logo.png') }}" >
        @section('head_css')
            <link rel="stylesheet" href="/css/app.css" />
        @show
    </head>
    <body>
        @section('header')
            @include('partials.header')
        @show

        <div class="main-container main">
            @yield('content')
        </div>

        <div id="modal_container"></div>
         @section('script_js')
             <script src="/js/global.js"></script>
             <script src="/js/bundle.js"></script>
             <script src="/js/charts.js"></script>
         @show
    <footer>
        @include("footer")
    </footer>
    </body>
</html>
