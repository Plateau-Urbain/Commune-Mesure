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
    'Personnes travaillant sur le site' => 'travailleur',
    'Tout le monde' => ''
  ];
@endphp

<h5 class="is-size-5 has-text-primary no-border is-uppercase">
  Publics
  @include('components.modals.modalEdition', ['chemin' => 'blocs->accessibilite->donnees->publics', 'id_section' => 'accessibilite','type' => 'checkbox','titre' => 'Modifier les différents publics','description'=>"Les différentes catégories de public accueillies au sein du lieu"])
</h5>

<div class="mb-3">
  @php $publics = $place->getPublics() @endphp
  @if (isset($publics['Tout le monde']) && $publics['Tout le monde'])
    @foreach($public_icons as $public => $icone)
      @if ($public === 'Tout le monde') @continue @endif

      <span class="cm-icons-container" title="{{ $public }}">
        <i class="cm-icons small {{ $icone }}" style="cursor: help"></i>
      </span>
    @endforeach
  @else
    @foreach($publics as $public => $check)
      @if($check )
        <span class="cm-icons-container" title="{{ $public }}">
          <i class="cm-icons small {{ $public_icons[$public] }}" style="cursor: help"></i>
        </span>
      @endif
    @endforeach
  @endif
</div>
