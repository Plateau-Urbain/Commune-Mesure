<h2 class="ribbon-banner title is-5 has-text-centered">L'impact social</h2>
<div class="columns" style="margin-top: 100px;">
  {{-- Gauche --}}
  <div class="column has-text-centered is-relative">

    <img width="300" src="/images/4_characters.png"/>

    <div class="impact_item bottom left" id="impact_item_reseaux" data-aos="fade-in">
          @php( $impact_reseau_text = $place->get('blocs->impact_social->donnees->reseaux') )
          @php ($impact_chemin='blocs->impact_social->donnees->reseaux')
      <div @isset($impact_reseau_text) data-tooltip="{{ $impact_reseau_text }}" @endisset class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_reseau_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
          <text x="45" y="40" font-size="8" font-weight="bold" fill="#004c44">Réseaux @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'type'=>'text','titre'=>"Modifier L'impact en rapport avec le réseau",'description'=>'En rapport avec le Réseau'])</text>
        </svg>
      </div>
    </div>

    <div class="impact_item top right" id="impact_item_appartenance" data-aos="fade-right">

          @php( $impact_appartenance_text = $place->get('blocs->impact_social->donnees->appartenance_exclusion'))
          @php ($impact_chemin='blocs->impact_social->donnees->appartenance_exclusion')

      <div @isset($impact_appartenance_text) data-tooltip="{{ $impact_appartenance_text }}" @endisset class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_appartenance_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
          <text x="35" y="38" font-size="8" font-weight="bold" fill="#004c44">Appartenance </text>
          <text x="40" y="46" font-size="8" font-weight="bold" fill="#004c44">ou exclusion  @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'type'=>'text','titre'=>"Modifier L'impact social",'description'=>"En rapport avec l'Appartenance et l'exclusion"])</text>
        </svg>
      </div>
    </div>
  </div>

  {{-- Droite --}}
  <div  class="column has-text-centered" style="position: relative;">

    <img width="200" src="/images/3_characters.png"/>

    <div class="impact_item top left" id="impact_item_sante" data-aos="fade-in">
          @php( $impact_sante_text = $place->get('blocs->impact_social->donnees->sante_bien_être') )
          @php ($impact_chemin='blocs->impact_social->donnees->sante_bien_être')

      <div @isset($impact_sante_text) data-tooltip="{{ $impact_sante_text }}" @endisset class="impact_tooltip has-tooltip-bottom  has-tooltip-multiline @empty($impact_sante_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10" />
          <text x="48" y="38" font-size="7" font-weight="bold" fill="#004c44">Santé</text>
          <text x="44" y="45" font-size="7" font-weight="bold" fill="#004c44">Bien être @include('components.modals.modalEdition',['chemin'=>$impact_chemin ,'type'=>'text','titre'=>"Modifier L'impact social",'description'=>"En rapport avec la Santé et le Bien être"])</text>
        </svg>
      </div>
    </div>

    <div class="impact_item bottom left" id="impact_item_insertion" data-aos="fade-in">

          @php($impact_insertion_text = $place->get('blocs->impact_social->donnees->insertion_professionnelle') )
          @php ($impact_chemin='blocs->impact_social->donnees->insertion_professionnelle')

      <div @isset($impact_insertion_text) data-tooltip="{{ $impact_insertion_text }}" @endisset class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_insertion_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
          <text x="45" y="38" font-size="8" font-weight="bold" fill="#004c44">Insertion</text>
          <text x="34" y="45" font-size="8" font-weight="bold" fill="#004c44">professionnelle @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'type'=>'text','titre'=>"Modifier L'impact social",'description'=>"En rapport avec l'Insertion professionnelle"])</text>
        </svg>
      </div>
    </div>

    <div class="impact_item top right" id="impact_item_lien" data-aos="fade-in">
          @php($impact_lien_text = $place->get('blocs->impact_social->donnees->lien_social'))
          @php ($impact_chemin='blocs->impact_social->donnees->lien_social')

      <div @isset($impact_lien_text) data-tooltip="{{ $impact_lien_text }}" @endisset class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_lien_text) impact_disabled @endisset">
        <svg  width="215" height="150" viewBox="20 20 75 40">
          <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10" />
          <text x="52" y="38" font-size="7" font-weight="bold" fill="#004c44">Lien</text>
          <text x="50" y="45" font-size="7" font-weight="bold" fill="#004c44">social @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'type'=>'text','titre'=>"Modifier L'impact social",'description'=>"En rapport avec le lien social"])</text>
        </svg>
      </div>
    </div>

    <div class="impact_item bottom right" id="impact_item_capacite" data-aos="fade-in">
          @php( $impact_capacite_text = $place->get('blocs->impact_social->donnees->capacite_agir'))
          @php ($impact_chemin='blocs->impact_social->donnees->capacite_agir')

      <div @isset( $impact_capacite_text ) data-tooltip="{{ $impact_capacite_text }}" @endisset class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_capacite_text) impact_disabled @endisset">
        <svg width="215" height="150" viewBox="20 20 75 40">
          <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
          <text x="43" y="38" font-size="8" font-weight="bold" fill="#004c44">Capacité</text>
          <text x="50" y="45" font-size="8" font-weight="bold" fill="#004c44">à agir @include('components.modals.modalEdition',['chemin'=>$impact_chemin,'type'=>'text','titre'=>"Modifier L'impact social",'description'=>"En rapport avec la Capacité à agir"])</text>
        </svg>
      </div>
    </div>

  </div>
</div>
