<div class="has-text-centered">
  <p class="mb-5">
    <strong>Les differents publics :</strong>
  </p>
</div>

<div class="columns is-multiline fontSize0-8em" style="justify-content:center;">
  @foreach($place->get('opening') as $publics)
    @foreach($publics->names as $public)
      @if($public == 'Enfants')
        <span class="is-block ml-3 public-icons has-tooltip-bottom" data-tooltip="Enfants"><i class="cm-icons enfants font-color-theme mr-1"></i></span>
      @endif
      @if($public == 'Étudiants')
        <span class="is-inline-block ml-3 public-icons has-tooltip-bottom" data-tooltip="Étudiants"><i class="cm-icons student font-color-theme mr-1"></i></span>
      @endif
      @if($public == 'Famille')
        <span class="is-block ml-3 public-icons has-tooltip-bottom" data-tooltip="Famille"><i class="cm-icons familles font-color-theme mr-1"></i></span>
      @endif
    @endforeach
  @endforeach
</div>

