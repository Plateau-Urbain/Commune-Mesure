<div class="fond-fil" id="fond-fil-4">
  <h2 class="sous-banner sous-banner-fil sos is-5 has-text-centered">LES VALEURS</h2>
</div>
<br>
<div class="columns">
    @foreach($place->get('blocs->valeurs->donnees') as $valeur => $tabExemples)
    @if(count($tabExemples)>0 || isset($edit))
      <div class="column">
        <p class="has-text-centered">
          <strong class="valeurs">{{$valeur}}</strong>
          @include('components.modals.modalEdition',['chemin'=>"blocs->valeurs->donnees->$valeur",'type'=>'text','id_section'=>'section03','titre'=>"Modifier Les valeurs",'description'=>"Donner des exemples en rapport avec la valeur : ".$valeur])&nbsp; &nbsp;
        <p>
        <div class='valeurs-exemples'>
          <ul>
          @foreach($tabExemples as $exemple)
            <li><strong>- {{$exemple}}</strong></li>
          @endforeach
          </ul>
        </div>

      </div>
          @endif
    @endforeach

</div>
