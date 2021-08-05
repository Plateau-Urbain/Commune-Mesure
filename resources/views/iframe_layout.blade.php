<!DOCTYPE html>
<html>
    <head>
      <meta charset="UTF-8">
        @section('head_css')
            <link rel="stylesheet" href="{{ url('/css/external.css') }}" />
        @show
    </head>
    <body>
      @include($partial, $params)
      @section('script_js')
         <script src="{{ url('/js/external.js') }}"></script>
      @show
    </body>
</html>
