<h2 class="ribbon-banner title is-5 has-text-centered">Les valeurs</h2>
<br>
<div class="columns">
    @foreach($place->get('blocs->valeurs->donnees') as $valeur => $tabExemples)
    @if(count($tabExemples)>0 || isset($edit))
      <div class="column has-text-centered " >
        <p><strong class="valeurs">{{$valeur}}</strong><p>
        @include('components.modals.modalEdition',['chemin'=>"blocs->valeurs->donnees->$valeur",'type'=>'text','titre'=>"Modifier Les valeurs",'description'=>"Donner des exemples en rapport avec le ".$valeur."?"])&nbsp; &nbsp;
        @foreach($tabExemples as $exemple)
          <p><strong>- {{$exemple}}</strong></p>
        @endforeach
        <br>
      </div>
          @endif
    @endforeach

</div>
