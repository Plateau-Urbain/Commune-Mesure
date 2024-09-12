@extends('impactsocial.layout')

@section('meta_share')
@include('partials.place.meta.opengraph')
@include('partials.place.meta.twitter')
@endsection

@section('script_js')
@parent
<script src="{{ url('/js/readmore.js') }}@manifest"></script>
  @include('js.place.modals')
@endsection

@section('content')

<div id="impact-page">
  <div class="columns is-gapless is-mobile" id="container">
    <div class="column is-full">
      <section id="sommaire">
        <div class="container">
          <a href="#effets_individuels" class="valeur individuel">
            <div class="text text--right">
              <h3>Effets<br> individuels</h3>
              <div class="intensity">
                @foreach ([1,2,3,4,5] as $e)
                  <span class="{{(!empty($place->get('blocs->impact_social->donnees->intensite_effets_individuels')) && $e > $place->get('blocs->impact_social->donnees->intensite_effets_individuels')) ? 'hidden' : ''}}">+</span>
                @endforeach
              </div>
            </div>
            <div>
              <img class="rounded {{ !empty($place->get('blocs->impact_social->donnees->intensite_effets_individuels')) ? 'size-'.$place->get("blocs->impact_social->donnees->intensite_effets_individuels") : 'size-1' }}" src="{{ url('/images/EFFETS-perso.png') }}">
            </div>
          </a>

          <a href="#effets_collectifs" class="valeur collectif">
            <div class="text text--right">
              <h3>Effets<br> collectifs</h3>
              <div class="intensity">
                @foreach ([1,2,3,4,5] as $e)
                  <span class="{{(!empty($place->get('blocs->impact_social->donnees->intensite_effets_collectifs')) && $e > $place->get('blocs->impact_social->donnees->intensite_effets_collectifs')) ? 'hidden' : ''}}">+</span>
                @endforeach
              </div>
            </div>
            <img class="rounded {{ !empty($place->get('blocs->impact_social->donnees->intensite_effets_collectifs')) ? 'size-'.$place->get("blocs->impact_social->donnees->intensite_effets_collectifs") : 'size-1' }}" src="{{ url('/images/EFFETS-collectifs.png') }}">
          </a>

          <a href="#effets_territoriaux" class="valeur territorial reverse">
            <div class="text">
              <h3>Effets<br> territoriaux</h3>
              <div class="intensity">
                @foreach ([1,2,3,4,5] as $e)
                  <span class="{{(!empty($place->get('blocs->impact_social->donnees->intensite_effets_territoriaux')) && $e > $place->get('blocs->impact_social->donnees->intensite_effets_territoriaux')) ? 'not-filled territorial' : ''}}">+</span>
                @endforeach
              </div>
            </div>
            <img class="rounded {{ !empty($place->get('blocs->impact_social->donnees->intensite_effets_territoriaux')) ? 'size-'.$place->get("blocs->impact_social->donnees->intensite_effets_territoriaux") : 'size-1' }}"" src="{{ url('/images/EFFETS-territoriaux.png') }}">
          </a>

          @if($place->get("blocs->impact_social->donnees->intensite_effets_urbains"))
            <a href="#effets_urbains" class="valeur urbain reverse">
              <div class="text">
                <h3>Effets sur<br> le projet urbain</h3>
              </div>
              <img class="rounded size-1" src="{{ url('/images/EFFETS-urbain.png') }}">
            </a>
          @endif

          @include('partials.place.sections.cloud-words')

          <img src="{{ url('/images/illustration-sommaire.png') }}" alt="sommaire">
        </div>
      </section>

      <section>
        <div class="custom-background">
          <span id="effets_individuels"></span>
          <h2 class="margin-image">effets individuels</h2>
          <div>
            @if (!empty($place->get('blocs->impact_social->donnees->lien_social')) || isset($edit))
            <div class="image-start">
              <img src="{{ url('/images/individuel-lien-social.png') }}" alt="lien individuel">
              <div>
                <h3>Lien social</h3>
                <p>
                  Des interactions sociales ont été observées entre différents publics :
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->impact_social_public', 'id_section' => 'impact_social', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du publique de l'impact sociale", 'description' => "Décrivez le public de l'impact sociale"])
                  <br><strong><ul class="dashed"><li>{!! formatArray($place->get('blocs->impact_social->donnees->impact_social_public'), '</li><li>') !!}</li></ul></strong>
                  Ces échanges ont été constatés @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->impact_social_occasion', 'id_section' => 'impact_social', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'échange du lien social", 'description' => "Décrivez à quels moments ces échanges ont été observés"])
                  <strong>{!! formatArray($place->get('blocs->impact_social->donnees->impact_social_occasion'), ', ', ' et ') !!}</strong>.<br>
                  Ces rencontres ont lieu @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->impact_social_frequence', 'id_section' => 'impact_social', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier la fréquence de l'impact sociale", 'description' => "Décrivez la fréquence de ces intéractions"])
                  <strong>{!! formatArray($place->get('blocs->impact_social->donnees->impact_social_frequence'), ', ', ' ou ') !!}</strong>.
                </p>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->lien_social', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du lien social", 'description' => "Décrivez le lien social en quelques mots"])
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->lien_social')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->sante_bien_être')) || isset($edit))
            <div class="image-start">
              <img src="{{ url('/images/sante.png') }}" alt="santé">
              <div>
                <h3>Santé</h3>
                <p>
                  Des changements significatifs dans les conditions physiques, sociales et psychiques des bénéficiaires du projet ont été observées. Certaines personnes ont fait part/ont paru : <br>
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->sante_effet', 'id_section' => 'impact_social', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte des effets observés sur la santé", 'description' => "Décrivez les effets sur la santé et le bien être en quelques mots"])
                  <strong><ul class="dashed"><li>{!! formatArray($place->get('blocs->impact_social->donnees->sante_effet'), '</li><li>') !!}</li></ul></strong>
                </p>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->sante_bien_être', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de la santé et du bien être", 'description' => "Décrivez la santé et le bien être en quelques mots"])
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->sante_bien_être')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->insertion_professionnelle')) || isset($edit))
            <div class="image-start">
              <img src="{{ url('/images/individuel-insertion-pro.png') }}" alt="insertion professionnelle">
              <div>
                <h3>Insertion professionnelle</h3>
                <p>
                  @if (!empty($place->get('blocs->impact_social->donnees->insertion_professionnelle_nb_personnes')))
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->insertion_professionnelle_nb_personnes', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'insertion professionnelle", 'description' => "Décrivez l'insertion professionnelle en quelques mots"])
                    Les actions de formation, d'accompagnement à la création d'activité ou à l'emploi ont bénéficiées à
                    {{ $place->get('blocs->impact_social->donnees->insertion_professionnelle_nb_personnes') }} personnes et ont permis à certaines personnes :
                  @endif
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->insertion_professionnelle_effets', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte des effets l'insertion professionnelle", 'description' => "Décrivez les effets de l'insertion professionnelle en quelques mots"])
                  <strong><ul class="dashed"><li>{!! formatArray($place->get('blocs->impact_social->donnees->insertion_professionnelle_effets'), '</li><li>') !!}</li></ul></strong>
                </p>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->insertion_professionnelle', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'insertion professionnelle", 'description' => "Décrivez l'insertion professionnelle en quelques mots"])
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->insertion_professionnelle')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->capacite_agir')) || isset($edit))
            <div class="image-start">
              <img src="{{ url('/images/individuel-capacite-agir.png') }}" alt="capacité à agir">
              <div>
                <h3>Capacité à agir</h3>
                <p>
                  @if (!empty($place->get('blocs->impact_social->donnees->capacite_agir_nombre')))
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->capacite_agir_nombre', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le nombre d'actions réalisées", 'description' => "Indiquez le nombre d'actions réalisées"])
                    {{ $place->get('blocs->impact_social->donnees->capacite_agir_nombre') }}
                    @if($place->get('blocs->impact_social->donnees->capacite_agir_nombre') == '1')
                      nouveau projet ou action
                    @else
                      nouveaux projets ou actions
                    @endif
                  @else
                    Des nouveaux projets ou actions
                  @endif
                  (atelier, évènement, marché, ...) imprévus
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->capacite_agir_porte', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier les personnes ayant portées les projets", 'description' => "Indiquez qui a portés les projets"])
                  <strong>{!! preg_replace("/\([^)]+\)/","", formatArray($place->get('blocs->impact_social->donnees->capacite_agir_porte'), ', ')) !!}</strong> ont émergés.
                </p>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->capacite_agir', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de la capacité à agir", 'description' => "Décrivez la capacité à agir en quelques mots"])
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->capacite_agir')])
              </div>
            </div>
            @endif
          </div>
        </div>
      </section>

      <section class="gray-background topography-background">
        <div>
          <span id="effets_collectifs"></span>
          <h2 class="orange center">effets collectifs</h2>
          <div class="row">
            @if (!empty($place->get('blocs->impact_social->donnees->solidarite')) || isset($edit))
            <div class="image-start">
              <img src="{{ url('/images/collectif-solidarite.png') }}" alt="collectif solidarite">
              <div>
                <h3>Solidarité</h3>
                <p>
                  Des échanges, dons ou mutualisations de
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->solidarite_type', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du type solidarité", 'description' => "Décrivez le type de solidarité en quelques mots"])
                  <strong>{!! preg_replace("/\([^)]+\)/","", formatArray($place->get('blocs->impact_social->donnees->solidarite_type'), ' et de ')) !!}</strong> ont été observés entre :
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->solidarite_public', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le public qui a bénéficié de la solidarite", 'description' => "Décrivez le public qui a bénéficié de la solidarite"])
                  <strong><ul class="dashed"><li>{!! formatArray($place->get('blocs->impact_social->donnees->solidarite_public'), '</li><li>') !!}</li></ul></strong>
                </p>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->solidarite', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de la solidarité", 'description' => "Décrivez la solidarité en quelques mots"])
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->solidarite')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->reseaux')) || isset($edit))
            <div class="image-start">
              <img src="{{ url('/images/collectif-reseau.png') }}" alt="effets collectifs">
              <div>
                <h3>Réseau de personnes</h3>
                <p>
                  La création de réseaux de personnes
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->reseaux_type', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du type de réseaux", 'description' => "Décrivez la raison de la création du réseau en quelques mots"])
                  <strong>{!! formatArray($place->get('blocs->impact_social->donnees->reseaux_type'), ', ')!!}</strong> a été observée entre :
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->reseaux_public', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du publique du réseaux", 'description' => "Décrivez quels types de personnes interviennent dans ce réseau"])
                  <strong><ul class="dashed"><li>{!! formatArray($place->get('blocs->impact_social->donnees->reseaux_public'), '</li><li>') !!}</li></ul></strong>
                </p>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->reseaux', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du réseaux", 'description' => "Décrivez le réseaux en quelques mots"])
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->reseaux')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->appartenance_exclusion_public')) || isset($edit))
            <div class="image-start">
              <img src="{{ url('/images/inclusion-exclusion.png') }}" alt="inclusion exclusion">
              <div>
                <h3>Sentiment d'inclusion ou d'exclusion</h3>
                <p>
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->appartenance_exclusion_public', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du public de l'appartenance et l'exclusion", 'description' => "Décrivez quels types de personnes on eu le sentiment d'appartenance ou d'exclusion en quelques mots"])
                  @if (formatArray($place->get('blocs->impact_social->donnees->appartenance_exclusion_public'), '') === 'non')
                    Aucun sentiment d'appartenance à un groupe ou d'exclusion n'a été observé.
                  @else
                    Il a été observé que <strong>{!! formatArray($place->get('blocs->impact_social->donnees->appartenance_exclusion_public'), '') !!}</strong>
                  @endif
                </p>
                @if (!empty($place->get('blocs->impact_social->donnees->appartenance_exclusion')))
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->appartenance_exclusion', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'appartenance et l'exclusion", 'description' => "Décrivez l'appartenance et l'exclusion en quelques mots"])
                @endif
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->appartenance_exclusion')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->egalite_homme_femme')) || isset($edit))
            <div class="image-start">
              <img src="{{ url('/images/collectif-egalite.png') }}" alt="collectif solidarite">
              <div>
                @php
                  $gender_equality = [];
                  if ($place->get('blocs->impact_social->donnees->egalite_homme_femme_gestion')) {
                    $gender_equality[$place->get('blocs->impact_social->donnees->egalite_homme_femme_gestion')[0]][] = "l'équipe de gestion et animation du lieu";
                  }
                  if ($place->get('blocs->impact_social->donnees->egalite_homme_femme_dirigeants')) {
                    $gender_equality[$place->get('blocs->impact_social->donnees->egalite_homme_femme_dirigeants')[0]][] = "les dirigeants";
                  }
                  if ($place->get('blocs->impact_social->donnees->egalite_homme_femme_occupants')) {
                    $gender_equality[$place->get('blocs->impact_social->donnees->egalite_homme_femme_occupants')[0]][] = "les résident.e.s et les occupant.e.s";
                  }
                  if ($place->get('blocs->impact_social->donnees->egalite_homme_femme_public')) {
                    $gender_equality[$place->get('blocs->impact_social->donnees->egalite_homme_femme_public')[0]][] = "les publics";
                  }
                @endphp
                <h3>égalité femmes/hommes</h3>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->egalite_homme_femme_gestion', 'link_text' => 'égalité équipe de gestion', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'égalité homme femme au sein de l'équipe de gestion", 'description' => "Indiquez si dans l'équipe de gestion il y a : plus d'hommes que de femmes, autant d'hommes que de femmes, plus de femmes que d'hommes"])<br>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->egalite_homme_femme_dirigeants', 'link_text' => 'égalité équipe dirigeantes', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'égalité homme femme au sein de l'équipe dirigeantes", 'description' => "Indiquez si dans l'équipe dirigeantes il y a : plus d'hommes que de femmes, autant d'hommes que de femmes, plus de femmes que d'hommes"])<br>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->egalite_homme_femme_occupants', 'link_text' => 'égalité équipe occupants/résidents', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'égalité homme femme au sein des résidents/occupants", 'description' => "Indiquez si dans les résidents/occupants il y a : plus d'hommes que de femmes, autant d'hommes que de femmes, plus de femmes que d'hommes"])<br>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->egalite_homme_femme_public', 'link_text' => 'égalité public', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'égalité homme femme au sein du public", 'description' => "Indiquez si dans le public il y a : plus d'hommes que de femmes, autant d'hommes que de femmes, plus de femmes que d'hommes"])

                <p>
                  @foreach ($gender_equality as $key => $publics)
                    Concernant {{implode(' et ', $publics)}}, <strong>{{strtolower($key)}} sont présent.e.s</strong>.<br/>
                  @endforeach
                </p>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->egalite_homme_femme', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'égalité homme femme", 'description' => "Décrivez l'égalité homme femme en quelques mots"])
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->egalite_homme_femme')])
              </div>
            </div>
            @endif
          </div>
        </div>
      </section>

      <section class="topography-background">
        <div>
          <div class="half-image">
            <div>
              <img src="{{ url('/images/quartier-territoire-cadre-vie.png') }}" alt="cadre de vie">
            </div>
            <div>
              <span id="effets_territoriaux"></span>
              <h2 class="quartier">effets sur le quartier et le territoire</h2>
              @if (!empty($place->get('blocs->impact_social->donnees->cadre_de_vie')) || isset($edit))
                <h3>Cadre de vie et attractivité du quartier</h3>
                <p>
                  @if (formatArray($place->get('blocs->impact_social->donnees->cadre_de_vie_image'), '') !== 'non')
                    Le projet a fait évoluer l'image du quartier / territoire
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->cadre_de_vie_image', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'image du cadre de vie", 'description' => "Décrivez si le cadre de vie a évolué de manière positive"])
                    {{formatArray($place->get('blocs->impact_social->donnees->cadre_de_vie_image'), '')}},
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->cadre_de_vie_type', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du type de changement du cadre de vie", 'description' => "Décrivez le type de changement en quelques mots"])
                    <strong>{!! formatArray($place->get('blocs->impact_social->donnees->cadre_de_vie_type'), '') !!}</strong>.
                  @endif
                </p>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->cadre_de_vie', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du cadre de vie", 'description' => "Décrivez le cadre de vie en quelques mots"])
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->cadre_de_vie')])
                <br>
              @endif
              @if (formatArray($place->get('blocs->impact_social->donnees->entretien_des_espaces_effets'), '') !== "non, aucun effet" || isset($edit))
                <h3>Entretien des espaces</h3>
                <p>
                  @if (formatArray($place->get('blocs->impact_social->donnees->entretien_des_espaces_effets'), '') === "des effets positifs")
                    Le projet a permis d'améliorer
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->entretien_des_espaces_effets_positif_type', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte des effets positifs de l'entretien des espaces", 'description' => "Décrivez le type d'effets positifs, liés à l'entretien des espaces en quelques mots"])
                    <strong>{!! formatArray($place->get('blocs->impact_social->donnees->entretien_des_espaces_effets_positif_type'), ' et ') !!} </strong>.
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->entretien_des_espaces_effets_positif_example', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'entretien des espaces", 'description' => "Décrivez l'entretien des espaces en quelques mots"])
                    @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->entretien_des_espaces_effets_positif_example')])
                  @else
                    Le projet a engendré
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_type', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte des effets négatifs de l'entretien des espaces", 'description' => "Décrivez le type d'effets négatifs, liés à l'entretien des espaces en quelques mots"])
                    <strong>{!! formatArray($place->get('blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_type'), ' et ') !!} </strong>.
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_example', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'entretien des espaces", 'description' => "Décrivez l'entretien des espaces en quelques mots"])
                    @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_example')])
                  @endif
                </p>
              @endif
            </div>
          </div>
          <div class="image-start">
            <img src="{{ url('/images/quartier-service-proximite.png') }}" alt="service de proxmité">
            <div>
              <h3>Services publics et de proximité</h3>
              <p>
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->services_publics_gestion', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte des effets sur les espaces", 'description' => "Décrivez les effets sur les espaces parmis : <ul><li>non, les nouveaux espaces ne sont pas nettoyés, entretenus, sécurisés</li><li>non, rien n'a changé pour les espaces existants</li><li>cela a permis d'améliorer la gestion urbaine par les services</li><li>surcharge de travail</li></ul>"])
                  @if(formatArray($place->get('blocs->impact_social->donnees->services_publics_gestion'), '') === "non, les nouveaux espaces ne sont pas nettoyés, entretenus, sécurisés")
                    Le projet n'a pas modifié la gestion urbaine par les services des collectivités ou de leurs partenaires (ramassage des ordures, propreté, entretien, sécurité...), les nouveaux espaces ne sont pas nettoyés, entretenus, sécurisés.
                  @elseif(formatArray($place->get('blocs->impact_social->donnees->services_publics_gestion'), '') === "non, rien n'a changé pour les espaces existants")
                    Le projet n'a rien changé dans la gestion urbaine des espaces existants par les services des collectivités ou de leurs partenaires (ramassage des ordures, propreté, entretien, sécurité...).
                  @elseif(formatArray($place->get('blocs->impact_social->donnees->services_publics_gestion'), '') === "cela a permis d'améliorer la gestion urbaine par les services")
                    Le projet a permis d'améliorer la gestion urbaine par les services des collectivités ou de leurs partenaires (ramassage des ordures, propreté, entretien, sécurité...).
                  @else
                    Le projet a créé une surcharge de travail et/ou n'avait pas été anticipé par les services des collectivités ou de leurs partenaires  (ramassage des ordures, propreté, entretien, sécurité...) mais ils se sont réorganisés.
                  @endif
                  <br>
                  @if(!empty($place->get('blocs->impact_social->donnees->services_publics_besoin_urgent')))
                    Le projet a permis de répondre à des besoins sociaux urgents du territoire :
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->services_publics_besoin_urgent', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte des besoins urgents", 'description' => "Décrivez la liste des besoins urgents auxquels à répondu le projet"])
                    <strong><ul class="dashed"><li>{!! formatArray($place->get('blocs->impact_social->donnees->services_publics_besoin_urgent'), '</li><li>') !!}</li></ul></strong>
                  @endif

                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->services_publics', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte des services publics", 'description' => "Décrivez les services publics en quelques mots"])
              </p>
              @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->services_publics')])
            </div>
          </div>
          <div class="image-start">
            <img src="{{ url('/images/quartier-innovations.png') }}" alt="innovation publique">
            <div>
              <h3>Innovation publique</h3>
              @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->innovation_publique_effet','link_text' => 'modification des pratiques', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'amélioration des façons de faire", 'description' => "Décrivez si le projet à modifié les façons de faire entre : <ul><li>non</li><li>cela a permis d'améliorer ou expérimenter de nouveaux modes de faire</li></ul>"])
              @if(formatArray($place->get('blocs->impact_social->donnees->innovation_publique_effet'), '') === "non")
                <p>La collaboration avec les partenaires publics et privés n'a pas fait évoluer leurs pratiques professionnelles.</p>
              @elseif (formatArray($place->get('blocs->impact_social->donnees->innovation_publique_effet'), '') === "cela a permis d'améliorer ou expérimenter de nouveaux modes de faire")
                <p>
                  @if (!empty($place->get('blocs->impact_social->donnees->innovation_publique_type')))
                    La collaboration avec les partenaires publics et privés a permis d'améliorer ou expérimenter de nouveaux modes de faire:
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->innovation_publique_type','link_text' => 'nouveaux modes de faire', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte des nouveaux modes de faire", 'description' => "Listez les nouvelles façons de faire"])
                    <strong>{!! formatArray($place->get('blocs->impact_social->donnees->innovation_publique_type'), '') !!}</strong>.
                  @else
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->innovation_publique_type','link_text' => 'nouveaux modes de faire', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte des nouveaux modes de faire", 'description' => "Listez les nouvelles façons de faire"])
                    La collaboration avec les partenaires publics et privés a permis d'améliorer ou expérimenter de nouveaux modes de faire.
                  @endif
                </p>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->innovation_publique', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'innovation_publique", 'description' => "Décrivez l'innovation publique en quelques mots"])
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->innovation_publique')])
              @else
                <p>La collaboration avec les partenaires publics et privés a permis d'améliorer ou expérimenter de nouveaux modes de faire mais cela a été difficile à mettre en oeuvre (surcharge de travail, réorganisation).</p>
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->innovation_publique', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'innovation_publique", 'description' => "Décrivez l'innovation publique en quelques mots"])
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->innovation_publique')])
              @endif
            </div>
          </div>
        </div>
      </section>

      <!-- <section class="blue-background">
        <div>
          <div class="half-image">
            <div>
              <span id="effets_urbains"></span>
              <h2 class="urbain">Impact sur le projet urbain</h2>
              <h3>Gouvernance partagée transitoire/pérenne</h3>
              <p>
                Le projet a été monté en lien avec le projet urbain, un comité de pilotage transversal au projet urbain et au lieu se réunit régulièrement.
              </p>
              <br>
              <h3>évolution du diagnostic de la programmation et du dessin</h3>
              <p>Le projet a un impact sur le diagnostic du projet urbain, il a permis de mieux connaitre les pratiques: modes d'habiter, travailler, jouer… sur le site. Il a fait évoluer le type d'espaces publics (ex: création d'espaces de jeu, de sports, espaces intimes, frontage, jardins partagés...), leurs ambiances</p>
              <br>
              <h3>Missions ou métiers émergeants</h3>
              <p>
                Le projet change mes méthodes de travail (ex: connexion plus forte avec le terrain, les besoins et usages du site)
              </p>
              @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->capacite_agir')])
            </div>
            <div>
              <img src="{{ url('/images/projet-urbain.png') }}" alt="projet urban">
            </div>
          </div>
        </div>
      </section> -->

    </div>
  </div>
</div>
@endsection
