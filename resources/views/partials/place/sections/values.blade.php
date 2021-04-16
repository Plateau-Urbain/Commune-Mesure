<div class="banner-image-and-fil">
  <div class="banner-image">
    <img src="/images/Les_valeurs.png">
  </div>
  <div class="banner-fil fil-4">
    <h2 class="sous-banner has-image-attached">Les valeurs</h2>
  </div>
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
