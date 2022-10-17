<div class="modal" id="modal-insee" style="z-index: 100000;">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <h2 class="modal-card-title">Découpage géographique</h2>
      <button class="delete modal-croix" aria-label="Close"></button>
    </header>
    <section class="modal-card-body">
      <div class="content">
        <h3>Choisissez un découpage géographique</h3>
        <div class="mb-5 control has-icons-left has-text-centered">
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
    </section>
    <footer class="modal-card-foot is-block">
      <button class="button is-success is-pulled-right modal-croix">Fermer</button>
    </footer>
  </div>
</div>

