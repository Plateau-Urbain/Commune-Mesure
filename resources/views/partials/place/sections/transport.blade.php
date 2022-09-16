<h4 class="subtitle is-5">
  Accès
  @include('components.modals.modalEdition', ['chemin'=>'blocs->accessibilite->donnees->transports', 'id_section'=>'accessibilite','type' => 'checkbox','titre' => 'Modifier les moyens de transports accessibles',"description"=>"L'accessibilité du lieu en transports en commun"])
</h4>

<div class="columns is-multiline">
  @foreach($place->getTransports() as $transport => $check)
    @if($transport == 'Bus' && $check)
      <span class="ml-3 public-icons">
        <i class="cm-icons bus font-color-theme mr-1"></i>
        <br/>Bus
      </span>
    @endif
    @if($transport == 'Métro' && $check)
      <span class="ml-3 public-icons">
        <i class="cm-icons metro font-color-theme mr-1"></i>
        <br/>Métro
      </span>
    @endif
    @if($transport == 'Train' && $check)
      <span class="ml-3 public-icons">
        <i class="cm-icons train font-color-theme mr-1"></i>
        <br/>Train
      </span>
    @endif
    @if($transport == 'Vélo' && $check)
      <span class="ml-3 public-icons">
        <i class="cm-icons velo font-color-theme mr-1"></i>
        <br/>Vélo
      </span>
    @endif
    @if($transport == 'Voiture' && $check)
      <span class="ml-3 public-icons">
        <i class="cm-icons voiture font-color-theme mr-1"></i>
        <br/>Voiture
      </span>
    @endif
  @endforeach
</div>
