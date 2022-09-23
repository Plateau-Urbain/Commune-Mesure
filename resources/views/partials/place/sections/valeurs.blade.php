<section id="valeurs" class="is-clearfix fond-bleu p-5">
  <div class="column is-8 is-offset-2">
    <img class="is-pulled-right" src="{{ url('/images/IDÉE_FONDATRICE.svg') }}">

    <h4 class="subtitle is-4 mb-0">Inauguration</h4>
    <p class="mb-5">{{ \Carbon\Carbon::create($place->get('blocs->presentation->donnees->date_ouverture'))->format('j F Y') }}</p>

    <h4 class="title has-text-primary no-border is-uppercase">L'idée fondatrice</h4>
    <p class="mb-5">
      {{ $place->get('blocs->presentation->donnees->idee_fondatrice') }}
      @include('components.modals.modalEdition', ['chemin' => 'blocs->presentation->donnees->idee_fondatrice', 'id_section' => 'valeurs', 'type' => 'text', 'titre' => "Modifier l'idée fondatrice", 'description'=>"L'idée fondatrice du lieu. Laisser vide pour ne pas l'afficher."])
    </p>

    <div class="section"></div>

    <h4 class="title has-text-primary no-border is-uppercase">
      Les valeurs portées
      <span class="icon-edit">
        @include('components.modals.modalEdition',['chemin'=>"blocs->valeurs->donnees", 'id_section'=>'valeurs','type' => 'checkbox','titre' => 'Modifier les 3 valeurs fondamentales de votre lieu','description'=>"Les valeurs fondamentales autour desquelles le projet du lieu s'est construit"])
      </span>
    </h4>
    <div class="columns is-multiline is-centered mb-5">
      @foreach($place->get('blocs->valeurs->donnees') as $valeur => $active)
        @if($active)
        <div class="column is-one-third-tablet is-one-quarter-desktop">
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

    <h4 class="title has-text-primary no-border is-uppercase">
      La programmation du lieu
    </h4>

    <br>

    <style>
        #wordcloud { vertical-align: middle;display: table-cell;}
        .word { font-size: 30px; margin-right: 40px;}
        .word:nth-of-type(6n){color: #cb4f4a;}
        .word:nth-of-type(6n+1){color: #df9f8d;}
        .word:nth-of-type(6n+2){color: #64616c;}
        .word:nth-of-type(6n+3){color: #262631;}
    </style>
    <div id="wordcloud">
      @foreach ($place->get('activites') as $activite)
        <span class="word subtitle">{{ html_entity_decode(str_replace(' ', "&nbsp;", $activite)) }}</span> &nbsp;
      @endforeach
    </div>

  </div>
</section>
