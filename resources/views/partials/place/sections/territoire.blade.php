<h2 class="ribbon-banner title is-5 has-text-centered">Le lieu dans son territoire</h2>
<div class="section">
  <div class="columns">
    <div class="column">
      <label class="is-pulled-right pt-4">Choississez un découpage géographique: </label>
    </div>
    <div class="column is-pulled-left">
      <div class="mb-5 control has-icons-left">
        <div class="select">
          <select id="selectGeo">
            <option value="iris" selected>Proximité immédiate</option>
            <option value="commune">Commune</option>
            <option value="departement">Département</option>
            <option value="region">Région</option>
          </select>
        </div>
        <span class="icon is-large is-left">
          <i class="fas fa-map"></i>
        </span>
      </div>
    </div>
  </div>

  <div class="columns card is-rounded">
    <div class="column " style="width: 100%; height: 35em;">
      <div id="map-insee"></div>
    </div>
    <div class="column is-7">
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

