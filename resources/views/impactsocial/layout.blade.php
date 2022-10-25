<!DOCTYPE html>
<html @yield('fixed-navbar', 'class=has-navbar-fixed-top')>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @section('meta_share')
        @show
        <title>Commune Mesure</title>
        <link rel="shortcut icon" href="{{ url('/images/logos/commune-mesure-logo.png') }}?{{ file_get_contents(base_path().'/.git/refs/heads/prod') }}" >
        @section('head_css')
            <link rel="stylesheet" href="{{ url('/css/app.css') }}?{{ file_get_contents(base_path().'/.git/refs/heads/prod') }}" />
        @show
    </head>
    <body>
        @section('header')
            @include('impactsocial.partials.header')
        @show

        <div class="main-container main">
            @yield('content')
        </div>

        @include("footer")

        <div id="modal_container">
          @stack('modals')
        </div>

        @section('script_js')
          <script src="{{ url('/js/global.js') }}?{{ file_get_contents(base_path().'/.git/refs/heads/prod') }}"></script>
          <script src="{{ url('/js/bundle.js') }}?{{ file_get_contents(base_path().'/.git/refs/heads/prod') }}"></script>
        @show
    </body>
</html>
