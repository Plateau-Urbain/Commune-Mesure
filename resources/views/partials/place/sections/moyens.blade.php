<section class="p-5">
  <div class="columns">
    <div class="column is-8 is-offset-2">
      <h4 class="is-size-4 has-text-primary no-border is-uppercase">Les moyens</h4>
      <p>Les moyens financiers mis en oeuvre pour assurer le fonctionnement du lieu.</p>

      <div class="section"></div>

      <div class="columns is-centered">
        @if(! $place->isEmptyFonctionnement() || isset($edit))
          <div class="column is-half">
              <h4 class="subtitle is-5">
                Fonctionnement
                @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->fonctionnement','id_section'=>'moyens','type'=>'number','titre'=>"Modifier le fonctionnement","description"=>"Le budget annuel de fonctionnement du projet"])
              </h4>

              <svg id="financement-budget-doughnut" width="400" height="400" aria-label="Répartition budget fonctionnement / investissement" role="img">
          </div>
        @endif

        @if(! $place->isEmptyInvestissement() || isset($edit))
          <div class="column is-half">
              <h4 class="subtitle is-5">
                Investissement
                @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->investissement','id_section'=>'moyens','type'=>'number','titre'=>"Modifier l'investissement",'description'=>"Le budget initial nécessaire au financement du projet et à l'ouverture du lieu (en %)"])
              </h4>

              <svg id="investissement-graph" width="400" height="400" aria-label="Répartition investissement" role="img"></svg>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
