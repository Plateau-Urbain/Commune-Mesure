<div class="has-text-centered">
  <p class="mb-5">
    <strong>Publics</strong>
    @include('components.modals.modalEdition',['chemin'=>'blocs->accessibilite->donnees->publics','id_section'=>'section02','type' => 'checkbox','titre' => 'Modifier les différents publics'])
  </p>
</div>
<div class="columns is-multiline fontSize0-8em" style="justify-content:center;">
    @foreach($place->getPublics() as $public => $check)
      @if($public == 'Enfants' && $check )
        <span class="is-block ml-3 public-icons has-tooltip-bottom" data-tooltip="Enfants"><i class="cm-icons enfants font-color-theme mr-1"></i></span>
      @endif
      @if($public == 'Étudiants' && $check)
        <span class="is-inline-block ml-3 public-icons has-tooltip-bottom" data-tooltip="Étudiants"><i class="cm-icons student font-color-theme mr-1"></i></span>
      @endif
      @if($public == 'Famille' && $check)
        <span class="is-block ml-3 public-icons has-tooltip-bottom" data-tooltip="Famille"><i class="cm-icons familles font-color-theme mr-1"></i></span>
      @endif
      @if($public == 'Personnes âgées' && $check)
        <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Personnes âgées"><i class="cm-icons mal-voyant font-color-theme mr-1"></i></span>
      @endif
    @endforeach
</div>
