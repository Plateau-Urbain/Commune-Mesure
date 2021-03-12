<h2 class="ribbon-banner title is-5 has-text-centered">Les valeurs</h2>
<div class="columns">
  <div class="column has-text-centered">
    @foreach($place->get('blocs->valeurs->donnees') as $valeur => $tabExemples)
        <label style="color:red">{{$valeur}}</label>
        @include('components.modals.modalEdition',['chemin'=>"blocs->valeurs->donnees->$valeur",'type'=>'text','titre'=>"Modifier Les valeurs",'description'=>"Donner des exemples en rapport avec le ".$valeur."?"])&nbsp; &nbsp;
        @foreach($tabExemples as $exemple)
          <p>{{$exemple}}</p>
        @endforeach
        <br>
    @endforeach
  </div>
</div>
