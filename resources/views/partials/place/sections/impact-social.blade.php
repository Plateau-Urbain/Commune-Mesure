<div class="banner-fil fil-5">
    <h2 class="sous-banner">L'impact social</h1>
</div>
<p class='description-section'>L’évaluation des effets sociaux est un processus collectif visant à qualifier l’ensemble des conséquences, négatives ou positives, prévues ou imprévues, d’un projet sur ses parties prenantes. Nous présentons ici 3 représentations simplifiées des effets à l’échelle individuelle, collective et territoriale. La visualisation des réponses détaillées, issues des porteurs de projet, sont accessibles sur la page <a href="{{ route('impacts.show',['slug' => $place->getSlug() ]) }}">voir ses effets sociaux</a>.</p>

<div class="columns is-multiline" style="margin-top: 100px;">
    {{-- Gauche --}}
  <div class="column has-text-centered is-relative is-full-tablet my-6 is-half-desktop">

    <img class="img-impact-social" width="200" src="{{ url('/images/Impact_individuel.png') }}"/>

    <div class="impact_item bottom left" id="impact_item_lien">
      @php $impact_lien_text = $place->get('blocs->impact_social->donnees->lien_social') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->lien_social' @endphp
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type' => 'text', 'titre' => "Modifier l'impact social", 'description' => "Entre quels publics pouvez-vous observer des interactions sur le site ? Merci de donner un exemple ou d'expliciter."])
      </div>
      <div @if(!empty($impact_lien_text)) data-tooltip="{{ $impact_lien_text }}" @endif class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_lien_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="52" y="38" font-size="7" font-weight="bold" fill="#004c44">Lien</text>
          <text x="50" y="45" font-size="7" font-weight="bold" fill="#004c44">social</text>
        </svg>
      </div>
    </div>
    <div class="impact_item top right" id="impact_item_sante">
      @php $impact_sante_text = $place->get('blocs->impact_social->donnees->sante_bien_être') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->sante_bien_être' @endphp
      <div @if(!empty($impact_sante_text)) data-tooltip="{{ $impact_sante_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_sante_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="48" y="38" font-size="7" font-weight="bold" fill="#004c44">Santé</text>
          <text x="44" y="45" font-size="7" font-weight="bold" fill="#004c44">Bien être</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type' => 'text', 'titre' => "Modifier l'impact social", 'description' => "Avez-vous pu observer un changement des conditions physiques, sociales ou psychiques chez les bénéficiaires du projet, qui puisse être directement lié au projet ? Merci de donner un exemple ou d'expliciter."])
      </div>
    </div>
    <div class="impact_item top left" id="impact_item_insertion">
      @php $impact_insertion_text = $place->get('blocs->impact_social->donnees->insertion_professionnelle') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->insertion_professionnelle' @endphp
      <div class="crayon-impact-social">
         @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type' => 'text', 'titre' => "Modifier l'impact social", 'description' => "Avez-vous mis en place des actions de formation, d’accompagnement à la création d’activité ou à l’emploi ? Merci de donner au moins un exemple ou d'expliciter."])
      </div>
      <div @if(!empty($impact_insertion_text)) data-tooltip="{{ $impact_insertion_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_insertion_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="45" y="38" font-size="7" font-weight="bold" fill="#004c44">Insertion</text>
          <text x="34" y="45" font-size="7" font-weight="bold" fill="#004c44">professionnelle</text>
        </svg>
      </div>
    </div>
    <div class="impact_item bottom right" id="impact_item_capacite">
      @php $impact_capacite_text = $place->get('blocs->impact_social->donnees->capacite_agir') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->capacite_agir' @endphp
      <div @if(!empty($impact_capacite_text)) data-tooltip="{{ $impact_capacite_text }}" @endif class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_capacite_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="43" y="38" font-size="7" font-weight="bold" fill="#004c44">Capacité</text>
          <text x="50" y="45" font-size="7" font-weight="bold" fill="#004c44">à agir</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type' => 'text', 'titre' => "Modifier l'impact social", 'description' => "De nouveaux projets ou actions (atelier, événement, marché...)imprévus et portés par les bénéficiaires ou occupants ont-il émergé dans le cadre du projet ? Merci de donner un exemple ou d'expliciter."])
      </div>
    </div>


  </div>
  {{-- Milieu --}}
  <div class="column has-text-centered is-relative is-full-tablet my-6 is-half-desktop">

    <img class="img-impact-social" width="300" src="{{ url('/images/Impact_collectif.png') }}"/>

    <div class="impact_item top right" id="impact_item_reseaux">
        @php $impact_reseau_text = $place->get('blocs->impact_social->donnees->reseaux') @endphp
        @php $impact_chemin='blocs->impact_social->donnees->reseaux' @endphp
      <div @if(!empty($impact_reseau_text)) data-tooltip="{{ $impact_reseau_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_reseau_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="45" y="38" font-size="7" font-weight="bold" fill="#004c44">Réseaux </text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type' => 'text', 'titre' => "Modifier l'impact social", 'description' => "Avez-vous pu observer la création de réseaux de personnes ? Merci de donner un exemple ou d'expliciter."])
      </div>
    </div>
    <div class="impact_item bottom right" id="impact_item_appartenance">
      @php $impact_appartenance_text = $place->get('blocs->impact_social->donnees->appartenance_exclusion') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->appartenance_exclusion' @endphp
      <div @if(!empty($impact_appartenance_text)) data-tooltip="{{ $impact_appartenance_text }}" @endif class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_appartenance_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="35" y="38" font-size="7" font-weight="bold" fill="#004c44">Appartenance </text>
          <text x="38" y="46" font-size="7" font-weight="bold" fill="#004c44">ou exclusion </text>
        </svg>
      </div>
      <div class="crayon-impact-social">
         @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type'=> 'text', 'titre' => "Modifier l'impact social", 'description' => "Diriez-vous que certaines personnes se sentent appartenir à un groupe, ou s'en sentent exclues? Merci de donner au moins un exemple ou d'expliciter."])
      </div>
    </div>
    <div class="impact_item top left" id="impact_item_solidarite">
      @php $impact_solidarite_text = $place->get('blocs->impact_social->donnees->solidarite') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->solidarite' @endphp
      <div class="crayon-impact-social">
         @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type' => 'text', 'titre' => "Modifier l'impact social", 'description'=>"Y-a-t-il des échanges, dons ou mutualisations entre personnes au sein du projet ? Merci de donner un exemple ou d'expliciter."])
      </div>
      <div @if(!empty($impact_solidarite_text)) data-tooltip="{{ $impact_solidarite_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_solidarite_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="45" y="38" font-size="7" font-weight="bold" fill="#004c44">Solidarité</text>
        </svg>
      </div>
    </div>
    <div class="impact_item bottom left" id="impact_item_egalite_homme_femme">
      @php $impact_egalite_homme_femme_text = $place->get('blocs->impact_social->donnees->egalite_homme_femme') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->egalite_homme_femme' @endphp
      <div class="crayon-impact-social">
         @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type' => 'text', 'titre' => "Modifier l'impact social", 'description' => "Concernant les publics visitant le site, avez-vous l'impression que la répartition hommes / femmes diffère en fonction des horaires, des lieux, des activités ? Préciser."])
      </div>
      <div @if(!empty($impact_egalite_homme_femme_text)) data-tooltip="{{ $impact_egalite_homme_femme_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_egalite_homme_femme_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="48" y="38" font-size="7" font-weight="bold" fill="#004c44">Egalité</text>
          <text x="34" y="45" font-size="7" font-weight="bold" fill="#004c44">femmes/hommes</text>

        </svg>
      </div>
    </div>

  </div>
  {{-- Droite --}}
  <div  class="column has-text-centered is-relative is-full-tablet is-half-desktop is-offset-one-quarter-desktop">

    <img class="img-impact-social" width="200" src="{{ url('/images/Impacts_territoriaux.png') }}"/>

    <div class="impact_item bottom left" id="impact_item_cadre_de_vie">
      @php $impact_cadre_de_vie_text = $place->get('blocs->impact_social->donnees->cadre_de_vie') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->cadre_de_vie' @endphp
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type' => 'text', 'titre' => "Modifier l'impact social", 'description' => "Avez-vous l'impression que le projet a fait évolué l'image du quartier ou du territoire ? Merci de donner un exemple ou d'expliciter."])
      </div>
      <div @if(!empty($impact_cadre_de_vie_text)) data-tooltip="{{ $impact_cadre_de_vie_text }}" @endif class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_cadre_de_vie_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="45" y="38" font-size="7" font-weight="bold" fill="#004c44">Cadre</text>
          <text x="45" y="45" font-size="7" font-weight="bold" fill="#004c44">de vie</text>
        </svg>
      </div>
    </div>
    <div class="impact_item top right" id="impact_item_entretien_des_espaces">
      @php $impact_entretien_des_espaces_text = $place->get('blocs->impact_social->donnees->entretien_des_espaces') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->entretien_des_espaces' @endphp
      <div @if(!empty($impact_entretien_des_espaces_text)) data-tooltip="{{ $impact_entretien_des_espaces_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_entretien_des_espaces_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="48" y="38" font-size="7" font-weight="bold" fill="#004c44">Entretien</text>
          <text x="46" y="45" font-size="7" font-weight="bold" fill="#004c44">et espaces</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type' => 'text', 'titre' => "Modifier l'impact social", 'description' => "Le projet a-t-il engendré des effets sur les espaces extérieurs du quartier ou sur l'environnement du site ? Merci de donner un exemple ou d'expliciter."])
      </div>
    </div>
    <div class="impact_item top left" id="impact_item_services_publics">
      @php $impact_services_publics_text = $place->get('blocs->impact_social->donnees->services_publics') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->services_publics' @endphp
      <div class="crayon-impact-social">
         @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type' => 'text', 'titre' => "Modifier l'impact social", 'description' => "Le projet a-t-il permis de répondre à des besoins sociaux urgents du territoire ? Merci de donner au moins un exemple ou d'expliciter."])
      </div>
      <div @if(!empty($impact_services_publics_text)) data-tooltip="{{ $impact_services_publics_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_services_publics_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="45" y="38" font-size="7" font-weight="bold" fill="#004c44">Services</text>
          <text x="46" y="45" font-size="7" font-weight="bold" fill="#004c44">publics</text>
        </svg>
      </div>
    </div>
    <div class="impact_item bottom right" id="impact_item_innovation_publique">
      @php $impact_innovation_publique_text = $place->get('blocs->impact_social->donnees->innovation_publique') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->innovation_publique' @endphp
      <div @if(!empty($impact_innovation_publique_text)) data-tooltip="{{ $impact_innovation_publique_text }}" @endif class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_innovation_publique_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="43" y="38" font-size="7" font-weight="bold" fill="#004c44">Innovation</text>
          <text x="46" y="45" font-size="7" font-weight="bold" fill="#004c44">publique</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition', ['chemin' => $impact_chemin, 'id_section' => 'impact_social', 'type' => 'text', 'titre' => "Modifier l'impact social", 'description' => "Avez-vous pu constater que vos modalités de collaboration avec les partenaires publics et privés ont fait évoluer leurs pratiques professionnelles ? Merci de donner au moins un exemple ou d'expliciter."])
      </div>
    </div>

  </div>
</div>
