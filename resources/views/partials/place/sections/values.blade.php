<div class="fond-fil" id="fond-fil-4">
  <h2 class="sous-banner sous-banner-fil sos is-5 has-text-centered">LES VALEURS</h2>
</div>
<br>
<div class="columns">

    @if(isset($edit))
      @php $i= count((array)$place->get('blocs->valeurs->donnees')) @endphp
    @else
      @php $i=0; @endphp
      @foreach($place->get('blocs->valeurs->donnees') as $valeur => $tabExemples)
        @if(count($tabExemples) > 0)
          @php $i++; @endphp
        @endif
      @endforeach
    @endif

    @foreach($place->get('blocs->valeurs->donnees') as $valeur => $tabExemples)
    @if(count($tabExemples)>0 || isset($edit))
      <div class="column">
        <p class="has-text-centered">
          <strong class="valeurs">{{$valeur}}</strong>
          @include('components.modals.modalEdition',['chemin'=>"blocs->valeurs->donnees->$valeur",'type'=>'text','id_section'=>'section03','titre'=>"Modifier Les valeurs",'description'=>"Donner des exemples en rapport avec la valeur : ".$valeur])&nbsp; &nbsp;
        <p>
        <div class='valeurs-exemples' style='width:{{$i}}0%;'>
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
