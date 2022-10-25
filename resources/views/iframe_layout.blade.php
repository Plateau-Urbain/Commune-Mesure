<!DOCTYPE html>
<html>
    <head>
      <meta charset="UTF-8">
        @section('head_css')
            <link rel="stylesheet" href="{{ url('/css/external.css') }}?{{ file_get_contents(base_path().'/.git/refs/heads/prod') }}" />
        @show
    </head>
    <body>
      @include($partial, $params)
      @section('script_js')
         <script src="{{ url('/js/external.js') }}?{{ file_get_contents(base_path().'/.git/refs/heads/prod') }}"></script>
      @show
    </body>
</html>
