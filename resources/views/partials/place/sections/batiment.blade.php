<svg
   width="240mm"
   height="180mm"
   viewBox="0 0 240 180"
   version="1.1"
   id="svg5"
   inkscape:version="1.1.2 (0a00cf5339, 2022-02-04)"
   sodipodi:docname="test2.svg"
   xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
   xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
   xmlns:xlink="http://www.w3.org/1999/xlink"
   xmlns="http://www.w3.org/2000/svg"
   xmlns:svg="http://www.w3.org/2000/svg">
  <sodipodi:namedview
     id="namedview7"
     pagecolor="#ffffff"
     bordercolor="#666666"
     borderopacity="1.0"
     inkscape:pageshadow="2"
     inkscape:pageopacity="0.0"
     inkscape:pagecheckerboard="0"
     inkscape:document-units="mm"
     showgrid="false"
     inkscape:zoom="0.6405233"
     inkscape:cx="350.49467"
     inkscape:cy="591.70369"
     inkscape:window-width="1920"
     inkscape:window-height="1011"
     inkscape:window-x="0"
     inkscape:window-y="0"
     inkscape:window-maximized="1"
     inkscape:current-layer="layer1" />
  <defs
     id="defs2">
    <rect
       x="-219.82759"
       y="637.24292"
       width="168.71735"
       height="20.994186"
       id="rect24637" />
  </defs>

  <g>
    <x-svg :path="'assets/images/batiment/decors/'.$batiment->getDecors(0)" class="" transform="translate(0, 120)" width=60 height=60 />
  </g>

  @for ($i = 0 ; $i < 3 ; $i++)
    @php
      $t = $batiment->getThematique($i);
      if ($t == '') { continue;}
    @endphp

    <g id="g929"
      @php
        $x = ($i % 2) ? 60 : 120;
        $y = intval($i / 2) ? 60 : 120;
        $part = (strpos($t, 'THEME_') === false) ? 'THEME_VIERGE' : $t;
      @endphp
       transform="translate({{ $x }},{{ $y }})"
      >
      <x-svg :path="'assets/images/batiment/themes/'.$part.'.svg'" class="" transform="" width=60 height=60 />

      @if (strpos($t, 'THEME_') === false)
      <text
         xml:space="preserve"
         id="text24635"
         transform="translate(13, -8)"
         style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:3px;line-height:20.4545px;font-family:sans-serif;-inkscape-font-specification:'sans-serif, Bold';font-variant-ligatures:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-east-asian:normal;text-align:center;letter-spacing:0px;word-spacing:0px;writing-mode:lr-tb;white-space:pre;shape-inside:url(#rect24637);fill:#c9514a;fill-opacity:1;stroke:none;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" >
         {{ mb_strtoupper($t) }}</text>
      @endif

    </g>
  @endfor

  <x-svg :path="'assets/images/batiment/decors/'.$batiment->getDecors(1)" class="" transform="translate(180, 120)" width=60 height=60 />
  <x-svg :path="'assets/images/batiment/'.$batiment->getToit('droite').'.svg'" class="" transform="translate(120, 0)" width=60 height=60 />
  <x-svg :path="'assets/images/batiment/'.$batiment->getToit('gauche').'.svg'" class="" transform="translate(60, 60)" width=60 height=60 />

  </g>
</svg>
