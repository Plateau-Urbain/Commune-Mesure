<div class='banner-fil fil-2'>
  <h2 class="sous-banner">Le lieu dans son territoire</h2>
</div>
<p class='description-section'> Les grandes données socio-économiques du territoire dans lequel le lieu s'inscrit</p>
<div class="section">
  <div class="columns">
    <div class="column has-text-centered is-half is-offset-one-quarter">
      <label>Choississez un découpage géographique: </label>
      <div class="mb-5 control has-icons-left">
        <div class="select">
          <span class="icon is-large is-left">
            <i class="fas fa-map"></i>
          </span>
          <select id="selectGeo">
            <option value="iris" selected>Proximité immédiate</option>
            <option value="commune">Commune</option>
            <option value="departement">Département</option>
            <option value="region">Région</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="columns is-multiline card is-rounded">
    <div class="column is-full-mobile" style="width: 100%; height: 35em;">
      <div id="map-insee"></div>
    </div>
    <div class="column is-two-thirds-desktop is-full-mobile">
      <div class="columns">
        <div class="column">
          <div id="actifsChart"></div>
          <div id="cateChart"></div>
          <div id="immoChart"></div>
        </div>
      </div>
    </div>
  </div>
</div>
