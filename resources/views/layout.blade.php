<!DOCTYPE html>
<html @yield('fixed-navbar', 'class=has-navbar-fixed-top')>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @section('meta_share')
        @show
        <title>Commune Mesure</title>
        <link rel="shortcut icon" href="{{ url('/images/logos/commune-mesure-logo.png') }}" >
        @section('head_css')
            <link rel="stylesheet" href="{{ url('/css/app.css') }}" />
        @show
    </head>
    <body>
        @section('header')
            @include('partials.header')
        @show

        <div class="main-container main">
            @yield('content')
        </div>

        @include("footer")

        <div id="modal_container">
          @stack('modals')
        </div>

        @section('script_js')
          <script src="{{ url('/js/global.js') }}"></script>
          <script src="{{ url('/js/bundle.js') }}"></script>
        @show
    </body>
</html>
