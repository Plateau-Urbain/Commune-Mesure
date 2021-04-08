<div class="has-text-centered">
  <p class="mb-5">
  <strong>Transports</strong>
  @include('components.modals.modalEdition',['chemin'=>'blocs->accessibilite->donnees->transports', 'id_section'=>'section02','type' => 'checkbox','titre' => 'Modifier les moyens de transports accessibles'])
  </p>
</div>
<div class="columns is-multiline fontSize0-8em" style="justify-content:center;">
  @foreach($place->getTransports() as $transport => $check)
    @if($transport == 'Bus' && $check)
      <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Bus"><i class="cm-icons bus font-color-theme mr-1"></i></span>
    @endif
    @if($transport == 'Métro' && $check)
      <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Métro"><i class="cm-icons metro font-color-theme mr-1"></i></span>
    @endif
    @if($transport == 'Voiture' && $check)
      <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Voiture"><i class="cm-icons voiture font-color-theme mr-1"></i></span>
    @endif
  @endforeach
</div>
