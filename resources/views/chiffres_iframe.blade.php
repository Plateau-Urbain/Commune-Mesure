<!DOCTYPE html>
<html>
    <head>
        @section('head_css')
            <link rel="stylesheet" href="/css/aos.css" />
            <link rel="stylesheet" href="/css/app.css" />
        @show
    </head>
    <body>
      @include('partials.external.chiffres', ["stats" => $stats, "coordinates" => $coordinates])
      @section('script_js')
         <script src="/js/global.js"></script>
         <script src="/js/bundle.js"></script>
         <script src="/js/animate.js"></script>

      @show
    </body>
</html>
