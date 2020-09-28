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
          <li><a href="#presentation">Présentation du lieu</a></li>
          <li><a href="#nos-valeurs">Nos valeurs</a></li>
          <li><a href="#finances">Les finances</a></li>
          <li><a href="#composition-lieu">La composition du lieu</a></li>
          <li><a href="#donnees-insee">Données INSEE</a></li>
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
