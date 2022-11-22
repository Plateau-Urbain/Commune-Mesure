<section id="moyens" class="content-block">
  <div class="columns">
    <div class="column is-8 is-offset-2">
      <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase mb-0">Les moyens</h4>
      <p class="mb-6">Les moyens financiers mis en oeuvre pour assurer le fonctionnement du lieu.</p>

        @if(! $place->isEmptyFonctionnement() || isset($edit))
          <div class="is-flex is-flex-direction-column">
            <h6 class="subtitle is-5 is-uppercase has-text-weight-bold mb-0">
              Fonctionnement
              @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->fonctionnement','id_section'=>'moyens','type'=>'number','titre'=>"Modifier le fonctionnement","description"=>"Le budget annuel de fonctionnement du projet"])
            </h6>

            <svg id="financement-budget-doughnut" width="100%" height="300" aria-label="Répartition budget fonctionnement / investissement" role="img">
          </div>
        @endif

        @if(! $place->isEmptyInvestissement() || isset($edit))
          <div class="is-flex is-flex-direction-column">
            <h6 class="subtitle is-5 is-uppercase has-text-weight-bold mb-0">
              Investissement
              @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->investissement','id_section'=>'moyens','type'=>'number','titre'=>"Modifier l'investissement",'description'=>"Le budget initial nécessaire au financement du projet et à l'ouverture du lieu (en %)"])
            </h6>

            <svg id="investissement-graph" width="100%" height="470" aria-label="Répartition investissement" role="img"></svg>
          </div>
        @endif
    </div>
  </div>
</section>
