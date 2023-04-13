<section id="impact_social" class="is-flex is-flex-direction-column is-justify-content-center content-block">
  <div class="columns">
    <div class="column is-3 is-offset-2">
      <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase">L'impact social</h4>
      <p>
        L'évaluation des effets sociaux est un processus collectif visant à qualifier l'ensemble des conséquences, négatives ou positives, prévues ou imprévues, d'un projet sur ses parties prenantes. Nous présentons ici une représentation simplifiée des effets à l'échelle individuelle, collective et territoriale. La visualisation des réponses détaillées, issues des porteurs de projet, sont accessibles sur la page « voir ses effets sociaux »
      </p>

      <p class="mt-5">
        <a href="{{ route('impacts.show',['slug' => $place->getSlug() ]) }}" class="button is-fullwidth mt-2">Voir ses effets sociaux</a>
        @isset($edit)
          <a href="{{ route('impacts.edit',['slug' => $place->getSlug(), 'auth' => $auth ]) }}" class="button is-fullwidth mt-2">Éditer les effets sociaux</a>
        @endisset
      </p>
    </div>

    <div class="container column">
      <div class="individuel">
        <h3>Effets<br> individuels</h3>
        <div class="intensity">
          @foreach ([1,2,3,4,5] as $e)
            <span class="{{(!empty($place->get('blocs->impact_social->donnees->intensite_effets_individuels')) && $e > $place->get('blocs->impact_social->donnees->intensite_effets_individuels')) ? 'not-filled' : ''}}">+</span>
          @endforeach
        </div>
      </div>

      <div class="territorial">
        <h3>Effets<br> territoriaux</h3>
        <div class="intensity">
          @foreach ([1,2,3,4,5] as $e)
            <span class="{{(!empty($place->get('blocs->impact_social->donnees->intensite_effets_territoriaux')) && $e > $place->get('blocs->impact_social->donnees->intensite_effets_territoriaux')) ? 'not-filled' : ''}}">+</span>
          @endforeach
        </div>
      </div>

      <div class="cloud-layer">
        <div class="cloud">
          @foreach (explode(',', $place->get("blocs->impact_social->donnees->mots_cles_effets_individuels")) as $key => $word)
            @if (!empty(trim($word)))
              <span class="word word-{{$key}}">#{{trim($word)}}</span>
            @endif
          @endforeach
          @foreach (explode(',', $place->get("blocs->impact_social->donnees->mots_cles_effets_collectifs")) as $key => $word)
            @if (!empty(trim($word)))
              <span class="word word-{{$key}}">#{{trim($word)}}</span>
            @endif
          @endforeach
          @foreach (explode(',', $place->get("blocs->impact_social->donnees->mots_cles_effets_territoriaux")) as $key => $word)
            @if (!empty(trim($word)))
              <span class="word word-{{$key}}">#{{trim($word)}}</span>
            @endif
          @endforeach
        </div>
      </div>
      <img class="image left" src="{{ url('/images/urbain.png') }}"/>
      <img class="image right" src="{{ url('/images/collectif-reseau-1.png') }}"/>

      <div class="collectif">
        <h3>Effets collectifs</h3>
        <div class="intensity">
          @foreach ([1,2,3,4,5] as $e)
            <span class="{{(!empty($place->get('blocs->impact_social->donnees->intensite_effets_collectifs')) && $e > $place->get('blocs->impact_social->donnees->intensite_effets_collectifs')) ? 'not-filled' : ''}}">+</span>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
