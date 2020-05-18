<html>
    <head>
        <title>{{ config('app.name') }}</title>
        @section('head_css')

        @show
    </head>
    <body>
        <header>
            <ul>
                <li><strong><em>{{ config('app.name') }}</em></strong></li>
                <li>About</li>
            </ul>
        </header>

        <div class="container">
            @yield('content')
        </div>

         @section('script_js')
    </body>
</html>
