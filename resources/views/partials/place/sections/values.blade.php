<div class="banner-image-and-fil">
  <div class="banner-image">
    <img src="{{ url('/images/Les_valeurs.png') }}">
  </div>
  <div class="banner-fil fil-4">
    <div>
    <h2 class="sous-banner has-image-attached">Les valeurs portées
      <span class="icon-edit">
        @include('components.modals.modalEdition',['chemin'=>"blocs->valeurs->donnees", 'id_section'=>'valeurs','type' => 'checkbox','titre' => 'Modifier les 3 valeurs fondamentales de votre lieu','description'=>"Les valeurs fondamentales autour desquelles le projet du lieu s'est construit"])
      </span>
    </h2>
  </div>
  </div>
  <p class='description-section'>Les valeurs fondamentales autour desquelles le projet du lieu s'est construit</p>
</div>
<br>
  <div class="columns is-multiline is-centered">
    @foreach($place->get('blocs->valeurs->donnees') as $valeur => $active)
      @if($active)
      <div class="column is-one-third-tablet is-one-quarter-desktop">
        <p class="has-text-centered"><strong class="valeurs has-text-primary">{{$valeur}}</strong></p>
        <p>
          {{ $place->get('blocs->valeurs->texte->'.$valeur) }}
        </p>
        <p class="has-text-centered">
          @include('components.modals.modalEdition', ['chemin' => 'blocs->valeurs->texte->'.$valeur, 'id_section' => 'valeurs', 'type' => 'text', 'titre' => 'Valeur : '.$valeur, 'description' => 'Le texte apparaitera sous la valeur.'])
        </p>
      </div>
      @endif
    @endforeach
  </div>

  <br>
  <br>

  <div class="field has-text-centered">
    <label class="is-size-5" style="font-weight: bold;" >La programmation du lieu</label>
  </div>

  <br>

  <style>
      #wordcloud { text-align: center; vertical-align: middle;display: table-cell;}
      .word { font-size: 30px;}
      .word:nth-of-type(6n){color: #cb4f4a;}
      .word:nth-of-type(6n+1){color: #df9f8d;}
      .word:nth-of-type(6n+2){color: #f6e6de;}
      .word:nth-of-type(6n+3){color: #c2c0c6;}
      .word:nth-of-type(6n+4){color: #64616c;}
      .word:nth-of-type(6n+5){color: #262631;}
  </style>
  <div class="columns is-multiline is-centered">
    <div class="has-text-centered" style="width:500px; height:300px" id="wordcloud">
      <span class="word">Occupation&nbsp;temporaire</span> &nbsp;
      <span class="word">Agriculture&nbsp;urbaine</span> &nbsp;
      <span class="word">Écologie</span> &nbsp;
      <span class="word">Culture</span> &nbsp;
      <span class="word">Hébergement&nbsp;d'urgence</span>
    </div>
  </div>
