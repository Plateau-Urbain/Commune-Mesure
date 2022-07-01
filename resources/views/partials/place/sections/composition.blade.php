<h2 class="sous-banner sous-banner-composition is-5 has-text-centered">LA COMPOSITION</h2>
<p class='description-section'>Nombre et nature des structures ayant leurs locaux ou exerçant leur activité au sein du lieu</p>
<div class="field has-text-centered">
  <label class="is-size-5" style="font-weight: bold;" >Type de structures participant au projet</label>
  @include('components.modals.modalEdition',['chemin'=>'blocs->composition->donnees->type','id_section'=>'composition','type'=>'number','titre'=>"Modifier les types de structures",'description'=>"Quelle est la nature juridique des structures présentes au sein du lieu ? (par ex. entreprise, association, artistes etc.)"])
</div>
  <div class="chart-container has-text-centered">
    <svg id="waffle" width=500 height=500 aria-label="Graphique répartition par structure" role="img"></svg>
  </div>
