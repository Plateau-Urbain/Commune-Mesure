<div class="section scrolling-menu">
  <aside id="info-box" class="mb-2">
      <h3 class="info-box-header">{{ $place->name }}</h3>
  </aside>
  <aside class="menu">
    <p class="menu-label">
      Menu
    </p>
    <ul class="menu-list">
      <li>
        <ul>
          @if(isset($edit))
          <li><a href="#section01">Présentation</a></li>
          <li><a href="#section02">Les valeurs</a></li>
          <li><a href="#section03">Les moyens</a></li>
          <li><a href="#section03">La composition</a></li>
          <li><a href="#section04">L'impact social</a></li>
          <li><a href="#section05">Le territoire</a></li>
          <li><a href="#section06">Galerie</a></li>
          @else
            @if($sections->get('bloc_gauche'))
              <li><a href="#section01">Présentation</a></li>
            @endif
            @if($sections->get('valeurs'))
              <li><a href="#section02">Les valeurs</a></li>
            @endif
            @if($sections->get('moyens'))
              <li><a href="#section03">Les moyens</a></li>
            @endif
            @if($sections->get('composition'))
              <li><a href="#section03">La composition</a></li>
            @endif
            @if($sections->get('reseau'))
              <li><a href="#section04">L'impact social</a></li>
            @endif
            @if($sections->get('lieu_territoire'))
              <li><a href="#section05">Le territoire</a></li>
            @endif
            @if($sections->get('gallerie'))
              <li><a href="#section06">Galerie</a></li>
            @endif
          @endif
        </ul>
      </li>
    </ul>
  </aside>
  <aside id="info-box" class="mb-2">
    <h3 class="info-box-header">Localisation</h3>
    <div class="info-box-content">
        <div id="info-box-map" class="info-box-map"></div>
        <a href="geo:{{ $place->geo->lat }},{{ $place->geo->lon }}">{{ $place->address->address }}, {{ $place->address->postalcode }} {{ $place->address->city }}</a>
    </div>
  </aside>

</div>
