<div class="banner-fil fil-5">
    <h2 class="sous-banner">L'impact social</h1>
</div>
<p class='description-section'> La qualification de l'impact social est le fruit d'un processus d'interaction; il se base sur des relations directes et indirectes, prévues et imprévues entre des actions, des personnes et leur milieu. Son estimation est nécessairement collective et propre à un contexte. Nous présentons ici 3 représentations simplifiées de l'impact social synthétisant les effets  sur les personnes, les groupes de personnes et le territoire. Les réponses affichées sont issues des porteurs de projet.</p>

<div class="columns" style="margin-top: 100px;">
    {{-- Gauche --}}
  <div class="column has-text-centered is-relative">

    <img class="img-impact-social" width="200" src="/images/Impact_individuel.png"/>

    <div class="impact_item bottom left" id="impact_item_lien" data-aos="fade-in">
      @php $impact_lien_text = $place->get('blocs->impact_social->donnees->lien_social') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->lien_social' @endphp
      <div @if(!empty($impact_lien_text)) data-tooltip="{{ $impact_lien_text }}" @endif class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_lien_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="52" y="38" font-size="7" font-weight="bold" fill="#004c44">Lien</text>
          <text x="50" y="45" font-size="7" font-weight="bold" fill="#004c44">social</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>"interactions entre les personnes sur le site"])
      </div>
    </div>
    <div class="impact_item top right" id="impact_item_sante" data-aos="fade-right">
      @php $impact_sante_text = $place->get('blocs->impact_social->donnees->sante_bien_être') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->sante_bien_être' @endphp
      <div @if(!empty($impact_sante_text)) data-tooltip="{{ $impact_sante_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_sante_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="48" y="38" font-size="7" font-weight="bold" fill="#004c44">Santé</text>
          <text x="44" y="45" font-size="7" font-weight="bold" fill="#004c44">Bien être</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition',['chemin'=>$impact_chemin ,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>"votre perception de l'évolution de la santé des personnes qui fréquentent le lieu"])
      </div>
    </div>
    <div class="impact_item top left" id="impact_item_insertion" data-aos="fade-in">
      @php $impact_insertion_text = $place->get('blocs->impact_social->donnees->insertion_professionnelle') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->insertion_professionnelle' @endphp
      <div @if(!empty($impact_insertion_text)) data-tooltip="{{ $impact_insertion_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_insertion_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="45" y="38" font-size="7" font-weight="bold" fill="#004c44">Insertion</text>
          <text x="34" y="45" font-size="7" font-weight="bold" fill="#004c44">professionnelle</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
         @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>"accès à l'emploi grâce à la présence des personnes qui fréquentent le lieu
Des personnes ou des activités mises en place sur le lieu ?"])
      </div>
    </div>
    <div class="impact_item bottom right" id="impact_item_capacite" data-aos="fade-in">
      @php $impact_capacite_text = $place->get('blocs->impact_social->donnees->capacite_agir') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->capacite_agir' @endphp
      <div @if(!empty($impact_capacite_text)) data-tooltip="{{ $impact_capacite_text }}" @endif class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_capacite_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="43" y="38" font-size="7" font-weight="bold" fill="#004c44">Capacité</text>
          <text x="50" y="45" font-size="7" font-weight="bold" fill="#004c44">à agir</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>"votre perception des Effets de la fréquentation du lieu sur la capacité à agir des personnes"])
      </div>
    </div>


  </div>
  {{-- Milieu --}}
  <div class="column has-text-centered is-relative">

    <img class="img-impact-social" width="300" src="/images/Impact_collectif.png"/>

    <div class="impact_item top right" id="impact_item_reseaux" data-aos="fade-in">
        @php $impact_reseau_text = $place->get('blocs->impact_social->donnees->reseaux') @endphp
        @php $impact_chemin='blocs->impact_social->donnees->reseaux' @endphp
      <div @if(!empty($impact_reseau_text)) data-tooltip="{{ $impact_reseau_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_reseau_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="45" y="38" font-size="7" font-weight="bold" fill="#004c44">Réseaux </text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>'les réseaux de personnes qui se sont constitués sur le lieu'])
      </div>
    </div>
    <div class="impact_item bottom right" id="impact_item_appartenance" data-aos="fade-right">
      @php $impact_appartenance_text = $place->get('blocs->impact_social->donnees->appartenance_exclusion') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->appartenance_exclusion' @endphp
      <div @if(!empty($impact_appartenance_text)) data-tooltip="{{ $impact_appartenance_text }}" @endif class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_appartenance_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="35" y="38" font-size="7" font-weight="bold" fill="#004c44">Appartenance </text>
          <text x="38" y="46" font-size="7" font-weight="bold" fill="#004c44">ou exclusion </text>
        </svg>
      </div>
      <div class="crayon-impact-social">
         @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>"votre perception de l'inclusion ou de l'exclusion des personnes sur le lieu"])
      </div>
    </div>
    <div class="impact_item top left" id="impact_item_solidarite" data-aos="fade-in">
      @php $impact_solidarite_text = $place->get('blocs->impact_social->donnees->solidarite') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->solidarite' @endphp
      <div @if(!empty($impact_solidarite_text)) data-tooltip="{{ $impact_solidarite_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_solidarite_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="45" y="38" font-size="7" font-weight="bold" fill="#004c44">Solidarité</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
         @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>""])
      </div>
    </div>
    <div class="impact_item bottom left" id="impact_item_egalite_homme_femme" data-aos="fade-in">
      @php $impact_egalite_homme_femme_text = $place->get('blocs->impact_social->donnees->egalite_homme_femme') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->egalite_homme_femme' @endphp
      <div @if(!empty($impact_egalite_homme_femme_text)) data-tooltip="{{ $impact_egalite_homme_femme_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_egalite_homme_femme_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="48" y="38" font-size="7" font-weight="bold" fill="#004c44">Egalité</text>
          <text x="34" y="45" font-size="7" font-weight="bold" fill="#004c44">femmes/hommes</text>

        </svg>
      </div>
      <div class="crayon-impact-social">
         @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>""])
      </div>
    </div>

  </div>
  {{-- Droite --}}
  <div  class="column has-text-centered" style="position: relative;">

    <img class="img-impact-social" width="200" src="/images/Impacts_territoriaux.png"/>

    <div class="impact_item bottom left" id="impact_item_cadre_de_vie" data-aos="fade-in">
      @php $impact_cadre_de_vie_text = $place->get('blocs->impact_social->donnees->cadre_de_vie') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->cadre_de_vie' @endphp
      <div @if(!empty($impact_cadre_de_vie_text)) data-tooltip="{{ $impact_cadre_de_vie_text }}" @endif class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_cadre_de_vie_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="45" y="38" font-size="7" font-weight="bold" fill="#004c44">Cadre</text>
          <text x="45" y="45" font-size="7" font-weight="bold" fill="#004c44">de vie</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>""])
      </div>
    </div>
    <div class="impact_item top right" id="impact_item_entretien_des_espaces" data-aos="fade-right">
      @php $impact_entretien_des_espaces_text = $place->get('blocs->impact_social->donnees->entretien_des_espaces') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->entretien_des_espaces' @endphp
      <div @if(!empty($impact_entretien_des_espaces_text)) data-tooltip="{{ $impact_entretien_des_espaces_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_entretien_des_espaces_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <text x="48" y="38" font-size="7" font-weight="bold" fill="#004c44">Entretien</text>
          <text x="46" y="45" font-size="7" font-weight="bold" fill="#004c44">et espaces</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition',['chemin'=>$impact_chemin ,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>""])
      </div>
    </div>
    <div class="impact_item top left" id="impact_item_services_publics" data-aos="fade-in">
      @php $impact_services_publics_text = $place->get('blocs->impact_social->donnees->services_publics') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->services_publics' @endphp
      <div @if(!empty($impact_services_publics_text)) data-tooltip="{{ $impact_services_publics_text }}" @endif class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_services_publics_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="45" y="38" font-size="7" font-weight="bold" fill="#004c44">Services</text>
          <text x="46" y="45" font-size="7" font-weight="bold" fill="#004c44">publics</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
         @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>""])
      </div>
    </div>
    <div class="impact_item bottom right" id="impact_item_innovation_publique" data-aos="fade-in">
      @php $impact_innovation_publique_text = $place->get('blocs->impact_social->donnees->innovation_publique') @endphp
      @php $impact_chemin='blocs->impact_social->donnees->innovation_publique' @endphp
      <div @if(!empty($impact_innovation_publique_text)) data-tooltip="{{ $impact_innovation_publique_text }}" @endif class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_innovation_publique_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <text x="43" y="38" font-size="7" font-weight="bold" fill="#004c44">Innovation</text>
          <text x="46" y="45" font-size="7" font-weight="bold" fill="#004c44">publique</text>
        </svg>
      </div>
      <div class="crayon-impact-social">
        @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'id_section'=>'impact_social','type'=>'text','titre'=>"Modifier l'impact social",'description'=>""])
      </div>
    </div>

  </div>
</div>
