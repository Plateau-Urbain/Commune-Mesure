<h4 class="is-size-4 has-text-primary no-border is-uppercase">
  Accessibilité
  @include('components.modals.modalEdition',['chemin'=>'blocs->accessibilite->donnees->accessibilite','id_section'=>'accessibilite','type' => 'checkbox','titre' => "Modifier l'accessibilité",'description'=>"L'accessibilité du lieu aux personnes à mobilité réduite ou en situation de handicap"])
</h4>

<div class="columns is-multiline">
    @foreach($place->getAccessibilite() as $accessibilite => $check)
      @if($accessibilite == 'Handicapés' && $check)
        <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Fauteuils roulants"><i class="cm-icons fauteuil-roulant font-color-theme mr-1"></i></span>
      @endif
      @if ($accessibilite == 'Mal voyants' && $check)
        <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Mal-voyants"><i class="cm-icons mal-voyant font-color-theme mr-1"></i></span>
      @endif
    @endforeach
</div>
