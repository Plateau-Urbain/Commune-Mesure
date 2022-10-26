<section id="impact_social" class="fond-bleu is-flex is-flex-direction-column is-justify-content-center content-block">
  <div class="columns">
    <div class="column is-3 is-offset-2">
      <h4 class="is-size-4 has-text-primary no-border is-uppercase">L'impact social</h4>
      <p>
        La qualification de l'impact social est le fruit d'un processus d'interaction; il se base sur des relations directes et indirectes, prévues et imprévues entre des actions, des personnes et leur milieu.  Son estimation est nécessairement collective et propre à un contexte. Nous présentons ici 3 représentations simplifiées de l'impact social synthétisant les eﬀets sur les personnes, les groupes de personnes et le territoire. Les réponses aﬀichées sont issues des porteurs de projet.
      </p>

      <p>
        <a href="{{ route('impacts.show',['slug' => $place->getSlug() ]) }}" class="button is-fullwidth mt-2">Voir ses effets sociaux</a>
        @isset($edit)
          <a href="{{ route('impacts.edit',['slug' => $place->getSlug(), 'auth' => $auth ]) }}" class="button is-fullwidth mt-2">Éditer les effets sociaux</a>
        @endisset
      </p>
    </div>

    <div class="column is-5 has-text-centered">
      <img class="img-impact-social" width="200" src="{{ url('/images/Impact_individuel.png') }}"/>
      <img class="img-impact-social" width="300" src="{{ url('/images/Impact_collectif.png') }}"/>
      <img class="img-impact-social" width="200" src="{{ url('/images/Impacts_territoriaux.png') }}"/>
    </div>
  </div>
</section>
