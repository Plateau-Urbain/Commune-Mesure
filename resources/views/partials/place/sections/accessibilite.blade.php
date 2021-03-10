<div class="has-text-centered">
  <p class="mb-5">
    <strong>Accessibilité:</strong>
    @include('components.modals.modalEdition',['chemin'=>'opening', 'type' => 'checkbox','titre' => "Modifier l'Accessibilité"])
  </p>
</div>
<div class="columns is-multiline fontSize0-8em" style="justify-content:center;">
    @foreach($place->getPublics() as $public => $check)
      @if($public == 'Handicapés' && $check)
        <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Fauteuils roulants"><i class="cm-icons fauteuil-roulant font-color-theme mr-1"></i></span>
      @endif
    @endforeach
  <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Mal-voyants"><i class="cm-icons mal-voyant font-color-theme mr-1"></i></span>
</div>
