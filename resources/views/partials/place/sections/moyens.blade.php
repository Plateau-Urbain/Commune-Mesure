<section id="moyens" class="content-block">
  <div class="columns">
    <div class="column is-8 is-offset-2">
      <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase mb-0">Les moyens</h4>
      <p>Les moyens financiers mis en oeuvre pour assurer le fonctionnement du lieu.</p>

        @if(! $place->isEmptyFonctionnement() || isset($edit))
          <div class="is-flex is-flex-direction-column my-6">
            <h6 class="subtitle is-6 is-uppercase has-text-weight-bold mb-3">
              Fonctionnement
            </h6>

            @if (isset($edit))
              <p style="margin-bottom: 10px"><strong>Le graphique ne s'affichera que lorsque les 4 valeurs seront remplies ! Veillez donc à bien complèter les 4 informations (même en remplissant la somme de 0 pour les moyens financiers qui ne vous concernent pas.)</strong></p>
              Modifier la somme des aides publiques
              @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->fonctionnement->Aides publiques','id_section'=>'moyens','type'=>'number','titre'=>"Modifier la somme des aides publiques",'description'=>"La somme des aides publiques (en chiffre)"])

              Modifier la somme des aides privées
              @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->fonctionnement->Aides privées','id_section'=>'moyens','type'=>'number','titre'=>"Modifier la somme des aides privées",'description'=>"La somme des aides privées (en chiffre)"])

              Modifier la somme des recettes
              @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->fonctionnement->Recettes','id_section'=>'moyens','type'=>'number','titre'=>"Modifier la somme des recettes",'description'=>"La somme des recettes (en chiffre)"])

              Modifier la somme des autres subventions
              @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->fonctionnement->Autres Subventions','id_section'=>'moyens','type'=>'number','titre'=>"Modifier la somme des autres subventions",'description'=>"La somme des autres subventions (en chiffre)"])
            @endif

            <svg id="financement-budget-doughnut" width="100%" height="300" aria-label="Répartition budget fonctionnement / investissement" role="img"></svg>
          </div>
        @endif

        @if(! $place->isEmptyInvestissement() || isset($edit))
          <div class="is-flex is-flex-direction-column my-6">
            <h6 class="subtitle is-6 is-uppercase has-text-weight-bold mb-3">
              Investissement
            </h6>

            @if (isset($edit))
              <p style="margin-bottom: 10px"><strong>Le graphique ne sera cohérent que lorsque les 3 valeurs seront remplies ! Veillez donc à bien complèter les 3 informations (même en remplissant un % 0 pour les investissements qui ne vous concernent pas.)</strong></p>

              Modifier la part des investissements publics
              @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->investissement->Fonds publics','id_section'=>'moyens','type'=>'number','titre'=>"Modifier l'investissement en fonds public",'description'=>"La part d'investissement en fonds publics (en %)"])

              Modifier la part des investissements privés
              @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->investissement->Fonds privés','id_section'=>'moyens','type'=>'number','titre'=>"Modifier l'investissement en fonds privés",'description'=>"La part d'investissement en fonds privés (en %)"])

              Modifier la part des investissements en fonds propres
              @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->investissement->Fonds apportés','id_section'=>'moyens','type'=>'number','titre'=>"Modifier l'investissement en fonds propres",'description'=>"La part d'investissement en fonds propres (en %)"])
            @endif

            <svg id="investissement-graph" width="100%" height="300" aria-label="Répartition investissement" role="img"></svg>
          </div>
        @endif
    </div>
  </div>
</section>
