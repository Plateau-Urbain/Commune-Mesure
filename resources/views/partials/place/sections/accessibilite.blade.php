<div class="has-text-centered">
  <p class="mb-5">
    <strong>Accessibilité</strong>
    @include('components.modals.modalEdition',['chemin'=>'blocs->accessibilite->donnees->accessibilite','id_section'=>'accessibilite','type' => 'checkbox','titre' => "Modifier l'accessibilité"])
  </p>
</div>
<div class="columns is-multiline fontSize0-8em" style="justify-content:center;">
    @foreach($place->getAccessibilite() as $accessibilite => $check)
      @if($accessibilite == 'Handicapés' && $check)
        <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Fauteuils roulants"><i class="cm-icons fauteuil-roulant font-color-theme mr-1"></i></span>
      @endif
      @if ($accessibilite == 'Mal voyants' && $check)
        <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Mal-voyants"><i class="cm-icons mal-voyant font-color-theme mr-1"></i></span>
      @endif
    @endforeach
</div>
