<h2 class="ribbon-banner title is-5 has-text-centered">Les valeurs</h2>
<br>
<div class="columns">
    @foreach($place->get('blocs->valeurs->donnees') as $valeur => $tabExemples)
    @if(count($tabExemples)>0 || isset($edit))
      <div class="column">
        <p class = 'has-text-centered'>
          <strong class="valeurs">{{$valeur}}</strong>
          @include('components.modals.modalEdition',['chemin'=>"blocs->valeurs->donnees->$valeur",'type'=>'text','titre'=>"Modifier Les valeurs",'description'=>"Donner des exemples en rapport avec la valeur : ".$valeur])&nbsp; &nbsp;
        <p>
        <div>
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
