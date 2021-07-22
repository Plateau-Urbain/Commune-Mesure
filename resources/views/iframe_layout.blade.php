<!DOCTYPE html>
<html>
    <head>
      <meta charset="UTF-8">
        @section('head_css')
            <link rel="stylesheet" href="/css/external.css" />
        @show
    </head>
    <body>
      @include($partial, $params)
      @section('script_js')
         <script src="/js/external.js"></script>
      @show
    </body>
</html>
