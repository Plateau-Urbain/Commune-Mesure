<div class="has-text-centered">
  <p class="mb-5">
    <strong>Accessibilité:</strong>
  </p>
</div>
<div class="columns is-multiline fontSize0-8em" style="justify-content:center;">
  @foreach($place->get('opening') as $publics)
    @foreach($publics->names as $public)
      @if($public == 'Handicapés')
        <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Fauteuils roulants"><i class="cm-icons fauteuil-roulant font-color-theme mr-1"></i></span>
      @endif
    @endforeach
  @endforeach
  <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Mal-voyants"><i class="cm-icons mal-voyant font-color-theme mr-1"></i></span>
</div>

