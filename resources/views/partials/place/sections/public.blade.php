@php
  $public_icons = [
    'Enfants' => 'enfants',
    'Étudiants' => 'student',
    'Famille' => 'familles',
    'Handicapés' => 'fauteuil-roulant',
    'Chercheurs d\'emplois' => 'chercheur-emploi',
    'Personnes âgées' => 'personnes-agees',
    'Personnes habitant sur le site' => 'habitant',
    'Personnes visitant le site' => 'visiteur',
    'Personnes travaillant sur le site' => 'travailleur'
  ];
@endphp

<h5 class="is-size-5 has-text-primary no-border is-uppercase">
  Publics
  @include('components.modals.modalEdition', ['chemin' => 'blocs->accessibilite->donnees->publics', 'id_section' => 'accessibilite','type' => 'checkbox','titre' => 'Modifier les différents publics','description'=>"Les différentes catégories de public accueillies au sein du lieu"])
</h5>

<div class="columns is-multiline">
  @foreach($place->getPublics() as $public => $check)
    @if($check )
      <span class="ml-3 cm-icons-container column is-3">
        <i class="cm-icons {{ $public_icons[$public] }} mr-1"></i>
        <br/>{{ $public }}
      </span>
    @endif
  @endforeach
</div>
