@php
  $accessibilite_icons = [
    'Handicapés' => 'fauteuil-roulant',
    'Mal voyants' => 'mal-voyant'
  ];
@endphp

<h5 class="is-size-5 has-text-primary no-border is-uppercase">
  Accessibilité
  @include('components.modals.modalEdition',['chemin'=>'blocs->accessibilite->donnees->accessibilite','id_section'=>'accessibilite','type' => 'checkbox','titre' => "Modifier l'accessibilité",'description'=>"L'accessibilité du lieu aux personnes à mobilité réduite ou en situation de handicap"])
</h5>

<div class="">
    @foreach($place->getAccessibilite() as $accessibilite => $check)
      @if($check )
        <span class="cm-icons-container" title="{{ $accessibilite }}">
          <i class="cm-icons small {{ $accessibilite_icons[$accessibilite] }}"></i>
        </span>
      @endif
    @endforeach
</div>
