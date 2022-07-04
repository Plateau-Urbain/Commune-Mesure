<?php

  $decors = ['CHIEN', 'CYCLISTE', 'FENETRE'];
  $themes = ["Convivialité", "Recyclage", "Éducation"];

  shuffle($decors);

  $theme2key = [
    'Accueil' => 'THEME_ACCUEIL',
    'Artisanat' => 'THEME_ARTISANAT',
    'Convivialité' => 'THEME_CONVIVIALITE',
    'Coworking' => 'THEME_COWORKING',
    'Recyclage' => 'THEME_RECYCLAGE',
  ];

  $thematiques = [];
  foreach($themes as $t) {
    $thematiques[] = (isset($theme2key[$t])) ? $theme2key[$t] : $t;
  }
  shuffle($thematiques);

 ?>
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
  <g
     inkscape:label="Calque 1"
     inkscape:groupmode="layer"
     id="layer1">
    <image
       width="60"
       height="60"
       preserveAspectRatio="none"
       xlink:href="{{ url('/images/batiment') }}/<?php echo $decors[0]; ?>.jpg"
       id="decor gauche"
       x="-60"
       y="120"
       transform="scale(-1,1)"
    />
<?php
for($i = 0 ; $i < 3 ; $i++):
        $t = $thematiques[$i];
        if ($t == 'VIDE') { continue;}
?>
  <g
     id="g929"
     transform="translate(<?php echo ($i % 2 ) ? '160' : '220'; ?>,<?php echo intval($i / 2) ? 60 : 120; ?>)">
    <image
       width="60"
       height="60"
       preserveAspectRatio="none"
       xlink:href="{{ url('/images/batiment') }}/<?php echo (strpos($t, 'THEME_') === false) ? 'THEME_VIERGE': $t; ?>.jpg"
       id="image1011"
       x="-100"
       y="0" />
<?php if (strpos($t, 'THEME_') === false): ?>
    <text
       xml:space="preserve"
       transform="matrix(0.26458333,0,0,0.26458333,-34.849449,-159.82525)"
       id="text24635"
       style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:10px;line-height:20.4545px;font-family:sans-serif;-inkscape-font-specification:'sans-serif, Bold';font-variant-ligatures:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-east-asian:normal;text-align:center;letter-spacing:0px;word-spacing:0px;writing-mode:lr-tb;white-space:pre;shape-inside:url(#rect24637);fill:#c9514a;fill-opacity:1;stroke:none;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
       x="-100"
       y="0"><tspan
         x="-170"
         y="650"
         id="tspan1129"><?php echo strtoupper($t); ?></tspan></text>
<?php endif; ?>
  </g>
<?php endfor; ?>
    <image
       width="60"
       height="60"
       preserveAspectRatio="none"
       xlink:href="{{ url('/images/batiment') }}/<?php echo $decors[1]; ?>.jpg"
       id="image856"
       x="180.3804"
       y="120.59917"
       />
    <image
       width="60"
       height="60"
       preserveAspectRatio="none"
       xlink:href="{{ url('/images/batiment/TOIT1.jpg') }}"
       id="image928"
       x="-180"
       y="0"
       transform="scale(-1,1)"
      />
     <image
        width="60"
        height="60"
        preserveAspectRatio="none"
        xlink:href="{{ url('/images/batiment/TOIT2.jpg') }}"
        id="image928"
        x="-120"
        y="60"
        transform="scale(-1,1)"
    />

  </g>
</svg>
