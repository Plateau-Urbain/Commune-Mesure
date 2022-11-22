<section id="impact_social" class="fond-bleu is-flex is-flex-direction-column is-justify-content-center content-block">
  <div class="columns">
    <div class="column is-3 is-offset-2">
      <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase">L'impact social</h4>
      <p>
        L'évaluation des effets sociaux est un processus collectif visant à qualifier l'ensemble des conséquences, négatives ou positives, prévues ou imprévues, d'un projet sur ses parties prenantes. Nous présentons ici 3 représentations simplifiées des effets à l'échelle individuelle, collective et territoriale. La visualisation des réponses détaillées, issues des porteurs de projet, sont accessibles sur la page « voir ses effets sociaux »
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
