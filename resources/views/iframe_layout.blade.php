<!DOCTYPE html>
<html>
    <head>
      <meta charset="UTF-8">
        @section('head_css')
            <link rel="stylesheet" href="{{ url('/css/external.css') }}@manifest" />
        @show
    </head>
    <body>
      @include($partial, $params)
      @section('script_js')
         <script src="{{ url('/js/external.js') }}@manifest"></script>
      @show
    </body>
</html>
