<html class="has-navbar-fixed-top">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        @section('head_css')
            <link rel="stylesheet" href="/css/bulma.min.css">
        @show
    </head>
    <body>
        <header>
            <nav class="navbar is-dark is-fixed-top" role="navigation" aria-label="main navigation">
                <div class="navbar-brand">
                    <a href="/" class="navbar-item"><strong>{{ config('app.name') }}</strong></a>
                    <a class="navbar-item">About</a>
                </div>
            </nav>
        </header>

        <div class="main">
            @yield('content')
        </div>

         @section('script_js')
         @show
    </body>
</html>
