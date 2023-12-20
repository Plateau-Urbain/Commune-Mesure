<section id="valeurs" class="is-clearfix content-block">
  <div class="columns">
    <div class="column is-8 is-offset-2">
      <img class="is-pulled-right is-half" src="{{ url('/images/IDÉE_FONDATRICE.svg') }}">

      <h4 class="subtitle is-4 mb-0">Inauguration</h4>
      <p class="mb-5">{{ \Carbon\Carbon::create($place->get('blocs->presentation->donnees->date_ouverture'))->isoFormat('LL') }}</p>

      <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase">L'idée fondatrice</h4>
      <p class="mb-5">
        {!! str_replace( "\\n", '<br />', $place->get('blocs->presentation->donnees->idee_fondatrice')) !!}
        @include('components.modals.modalEdition', ['chemin' => 'blocs->presentation->donnees->idee_fondatrice', 'id_section' => 'valeurs', 'type' => 'text', 'titre' => "Modifier l'idée fondatrice", 'description'=>"L'idée fondatrice du lieu. Laisser vide pour ne pas l'afficher."])
      </p>

      <div class="section"></div>

      <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase">
        Les valeurs portées
        <span class="icon-edit">
          @include('components.modals.modalEdition',['chemin'=>"blocs->valeurs->donnees", 'id_section'=>'valeurs','type' => 'checkbox','titre' => 'Modifier les 3 valeurs fondamentales de votre lieu','description'=>"Les valeurs fondamentales autour desquelles le projet du lieu s'est construit"])
        </span>
      </h4>
      <div class="columns is-multiline mb-5">
        @foreach($place->get('blocs->valeurs->donnees') as $valeur => $active)
          @if($active)
          <div class="column is-half-tablet is-one-third-desktop">
            <p class="subtitle"><strong class="valeurs">{{$valeur}}</strong></p>
            <p>
              @if (isset($edit) && ! $place->get('blocs->valeurs->texte->'.$valeur))
                Expliquez comment cette valeur s'incarne dans votre lieu.
              @else
                {{ $place->get('blocs->valeurs->texte->'.$valeur) }}
              @endif
            </p>
            <p class="subtitle">
              @include('components.modals.modalEdition', ['chemin' => 'blocs->valeurs->texte->'.$valeur, 'id_section' => 'valeurs', 'type' => 'text', 'titre' => 'Valeur : '.$valeur, 'description' => 'Le texte apparaitera sous la valeur.'])
            </p>
          </div>
          @endif
        @endforeach
      </div>

      <div class="section"></div>

      <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase">
        La programmation du lieu
      </h4>

      <br>

      <div id="wordcloud">
        @if (is_array($place->get('activites')))
          @foreach ($place->get('activites') as $activite)
          <span class="word subtitle">{{ $activite }}</span>
          @endforeach
        @endif

      </div>
    </div>
  </div>
</section>
