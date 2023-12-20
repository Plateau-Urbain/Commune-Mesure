<section id="composition" class="content-block">
      <div class="columns is-variable">
        <div class="column is-hidden-tablet">
          <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase">La composition</h4>
          <p>Nombre et nature des structures ayant leurs locaux ou exerçant leur activité au sein du lieu.</p>
        </div>

        <div class="column has-text-centered">
          <div>
            <svg id="waffle" width="100%" height="420" aria-label="Graphique répartition par structure" role="img" style="max-width: 420px"></svg>
            @include('components.modals.modalEdition',['chemin'=>'blocs->composition->donnees->type','id_section'=>'composition','type'=>'number','titre'=>"Modifier les types de structures",'description'=>"Quelle est la nature juridique des structures présentes au sein du lieu ? (par ex. entreprise, association, artistes etc.)"])
          </div>
        </div>

        <div class="column">
          <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase is-hidden-mobile mb-0" style="word-break: keep-all">La composition</h4>
          <p class="is-hidden-mobile">Nombre et nature des structures ayant leurs locaux ou exerçant leur activité au sein du lieu.</p>

          <div class="nombre-structures my-2">
            @if (isset($edit) || $place->get('blocs->presentation->donnees->nombre_occupants') > 0)
              <div class="is-inline-block">
                <span class="is-size-1 has-text-primary has-text-weight-bold font-renner-black">
                  {{
                    abs((int) filter_var($place->get('blocs->composition->donnees->type->Entreprises'), FILTER_SANITIZE_NUMBER_INT)) +
                    abs((int) filter_var($place->get('blocs->composition->donnees->type->Associations'), FILTER_SANITIZE_NUMBER_INT)) +
                    abs((int) filter_var($place->get('blocs->composition->donnees->type->Artistes'), FILTER_SANITIZE_NUMBER_INT)) +
                    abs((int) filter_var($place->get('blocs->composition->donnees->type->Autres structures'), FILTER_SANITIZE_NUMBER_INT))
                  }}
                </span>
                <br/>
                <p style="line-height: 1">
                  {{ $place->get('blocs->presentation->donnees->nombre_occupants') > 1 ? 'structures occupantes' : 'structure occupante' }}
                  @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->nombre_occupants','id_section'=>'presentation','type' => 'number','titre'=>"Modifier le nombre de structures occupantes",'description' =>"Le nombre de structures exerçant leur activité ou  ayant leurs  locaux au sein du lieu"])
                </p>
              </div>
            @endif

            @if (isset($edit) || $place->get('blocs->composition->donnees->structures_crees') > 0)
              <div class="is-inline-block">
                <span class="is-size-1 has-text-primary has-text-weight-bold font-renner-black">
                  {{ $place->get('blocs->composition->donnees->structures_crees') }}
                </span>
                <br/>
                <p style="line-height: 1">{{ $place->get('blocs->composition->donnees->structures_crees') > 1 ? 'structures créées' : 'structure créée' }}</p>
                @include('components.modals.modalEdition',['chemin'=>'blocs->composition->donnees->structures_crees','id_section'=>'presentation','type' => 'number','titre'=>"Modifier le nombre de structures créées",'description' =>"Le nombre de structures créées au sein du lieu"])
              </div>
            @endif
          </div>

          @if(!$place->isEmptyAccessibilityBySection('publics') && !isset($edit) || isset($edit))
            @include('partials.place.sections.public')
          @endif

          @if(!$place->isEmptyAccessibilityBySection('accessibilite')&& !isset($edit) || isset($edit))
            @include('partials.place.sections.accessibilite')
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
