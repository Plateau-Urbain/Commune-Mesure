<html class="has-navbar-fixed-top">
    <head>
        <title>{{ config('app.name') }}</title>
        @section('head_css')
            <link rel="stylesheet" href="/css/bulma.min.css">
        @show
    </head>
    <body>
        <header>
            <nav class="navbar is-dark is-fixed-top" role="navigation" aria-label="main navigation">
                <div class="navbar-brand">
                    <div class="navbar-start">
                        <a class="navbar-item"><strong>{{ config('app.name') }}</strong></a>
                        <a class="navbar-item">About</a>
                    </div>
                </div>
                </ul>
            </nav>
        </header>

        <div class="main">
            @yield('content')
        </div>

         @section('script_js')
    </body>
</html>
