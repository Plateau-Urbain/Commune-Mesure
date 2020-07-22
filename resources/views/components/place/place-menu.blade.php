<div class="section scrolling-menu">
  <aside id="info-box" class="mb-2">
    <h3 class="info-box-header">Informations</h3>
    <div class="info-box-content">
        <div class="columns is-gapless">
            <div class="column is-half">
                <span class="info-box-entry">Nom</span>
            </div>
            <div class="column is-half">
                {{ $place->name }}
            </div>
        </div>
    </div>

    <h3 class="info-box-header">Localisation</h3>
    <div class="info-box-content">
        <div id="info-box-map" class="info-box-map"></div>
        <dl>
            <dt><a href="geo:{{ $place->geo->lat }},{{ $place->geo->lon }}">Adresse</a></dt>
            <dd>{{ $place->address->address }}, {{ $place->address->postalcode }} {{ $place->address->city }}</dd>
        </dl>
    </div>
  </aside>
  <aside class="menu">
    <p class="menu-label">
      Menu
    </p>
    <ul class="menu-list">
      <li>
        <ul>
          <li><a href="#presentation">Présentation du lieu</a></li>
          <li><a href="#indicateurs-martin">Indicateurs de Martin</a></li>
          <li><a href="#indicateurs-approche">Indicateurs d'Approche</a></li>
          <li><a href="#donnees-insee">Données INSEE</a></li>
        </ul>
      </li>
    </ul>
  </aside>
</div>
