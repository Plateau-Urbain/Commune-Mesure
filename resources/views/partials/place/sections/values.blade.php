<div class="banner-image-and-fil">
  <div class="banner-image">
    <img src="/images/Les_valeurs.png">
  </div>
  <div class="banner-fil fil-4">
    <div>
    <h2 class="sous-banner has-image-attached">Les valeurs portées
      <span class="icon-edit">
        @include('components.modals.modalEdition',['chemin'=>"blocs->valeurs->donnees", 'id_section'=>'valeurs','type' => 'checkbox','titre' => 'Modifier les trois valeurs fondamentales de votre lieu'])
      </span>
    </h2>
  </div>

  </div>
</div>
<br>
<div class="columns">
    @foreach($place->get('blocs->valeurs->donnees') as $valeur => $tabExemples)
      @if ($tabExemples->check)
      <div class="column">
        <p class="has-text-centered">
          <strong class="valeurs">{{$valeur}}</strong>
          <!-- @include('components.modals.modalEdition',['chemin'=>"blocs->valeurs->donnees->".$valeur."->donnees",'type'=>'text','id_section'=>'valeurs','titre'=>"Modifier les valeurs",'description'=>"Donner des exemples en rapport avec la valeur : ".$valeur])&nbsp; &nbsp; -->
        <p>
        <!-- @if(isset($tabExemples->donnees) && count($tabExemples->donnees) >0)
          <div class='valeurs-exemples' style='width:30%;'>
            <ul>
            @foreach($tabExemples->donnees as $exemple)
              <li><strong>- {{ $exemple}}</strong></li>
            @endforeach
            </ul>
          </div>
        @endif -->

      </div>
      @endif
    @endforeach

</div>
