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
                  <span class="{{(!empty($place->get('blocs->impact_social->donnees->intensite_effets_individuels')) && $e > $place->get('blocs->impact_social->donnees->intensite_effets_individuels')) ? 'not-filled individuel' : ''}}">+</span>
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
                  <span class="{{(!empty($place->get('blocs->impact_social->donnees->intensite_effets_collectifs')) && $e > $place->get('blocs->impact_social->donnees->intensite_effets_collectifs')) ? 'not-filled collectif' : ''}}">+</span>
                @endforeach
              </div>
            </div>
            <img class="rounded {{ !empty($place->get('blocs->impact_social->donnees->intensite_effets_collectifs')) ? 'size-'.$place->get("blocs->impact_social->donnees->intensite_effets_collectifs") : 'size-1' }}"" src="{{ url('/images/EFFETS-collectifs.png') }}">
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

          <a href="#effets_urbains" class="valeur urbain reverse">
            <div class="text">
              <h3>Effets sur<br> le projet urbain</h3>
            </div>
            <img class="rounded size-1" src="{{ url('/images/EFFETS-urbain.png') }}">
          </a>

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
                  Des interactions sociales ont été observées entre les {{ formatArray($place->get('blocs->impact_social->donnees->impact_social_public'), "et") }}
                  {{ formatArray($place->get('blocs->impact_social->donnees->impact_social_occasion'), ' ') }} {{ formatArray($place->get('blocs->impact_social->donnees->impact_social_frequence'), ' ') }}
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->lien_social', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du lien social", 'description' => "Décrivez le lien social en quelques mots"])
                </p>
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
                  {{ ucfirst(formatArray($place->get('blocs->impact_social->donnees->sante_effet'), ',')) }}
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->sante_bien_être', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de la santé et du bien être", 'description' => "Décrivez la santé et le bien être en quelques mots"])
                </p>
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
                    Les actions de formation, d'accompagnement à la création d'activité ou à l'emploi ont bénéficiées à
                    {{ $place->get('blocs->impact_social->donnees->insertion_professionnelle_nb_personnes') }} personnes.
                  @endif

                  {{ ucfirst(formatArray($place->get('blocs->impact_social->donnees->insertion_professionnelle_effets'), ',')) }}
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->insertion_professionnelle', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'insertion professionnelle", 'description' => "Décrivez l'insertion professionnelle en quelques mots"])
                </p>
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
                    {{ $place->get('blocs->impact_social->donnees->capacite_agir_nombre') }}
                  @else
                    Des
                  @endif
                  nouveaux projets ou actions (atelier, évènement, marché, ...) imprévus {{ formatArray($place->get('blocs->impact_social->donnees->capacite_agir_porte'), ' , ') }} et ont émergés.
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->capacite_agir', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de la capacité à agir", 'description' => "Décrivez la capacité à agir en quelques mots"])
                </p>
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
                  Des échanges, dons ou mutualisations de {{ formatArray($place->get('blocs->impact_social->donnees->solidarite_type'), ' et de ') }}
                  entre {{ formatArray($place->get('blocs->impact_social->donnees->solidarite_public'), ' et ') }} ont été observés.
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->solidarite', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de la solidarité", 'description' => "Décrivez la solidarité en quelques mots"])
                </p>
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
                  La création de réseaux de personnes entre {{ formatArray($place->get('blocs->impact_social->donnees->reseaux_public'), ' et de ') }},
                  {{ formatArray($place->get('blocs->impact_social->donnees->reseaux_type'), ' , ') }} a été observée.
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->reseaux', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du réseaux", 'description' => "Décrivez le réseaux en quelques mots"])
                </p>
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
                  @if (formatArray($place->get('blocs->impact_social->donnees->appartenance_exclusion_public'), '') === 'non')
                    Aucun sentiment d'appartenance à un groupe ou d'exclusion n'a été observé.
                  @else
                    Il a été observé que {{ formatArray($place->get('blocs->impact_social->donnees->appartenance_exclusion_public'), '') }}
                  @endif
                  @if (!empty($place->get('blocs->impact_social->donnees->appartenance_exclusion')))
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->appartenance_exclusion', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'appartenance et l'exclusion", 'description' => "Décrivez l'appartenance et l'exclusion en quelques mots"])
                  @endif
                </p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->appartenance_exclusion')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->egalite_homme_femme')) || isset($edit))
            <div class="image-start">
              <img src="{{ url('/images/collectif-egalite.png') }}" alt="collectif solidarite">
              <div>
                <h3>égalité femmes/hommes</h3>
                <p>
                  Concernant l'équipe de gestion et animation du lieu, {{formatArray($place->get('blocs->impact_social->donnees->egalite_homme_femme_gestion'), '')}} sont présent.e.s<br>
                  Concernant les dirigeants, {{formatArray($place->get('blocs->impact_social->donnees->egalite_homme_femme_dirigeants'), '')}} sont présent.e.s<br>
                  Concernant les résident.e.s et les occupant.e.s, {{formatArray($place->get('blocs->impact_social->donnees->egalite_homme_femme_occupants'), '')}} sont présent.e.s<br>
                  Concernant les publics, {{formatArray($place->get('blocs->impact_social->donnees->egalite_homme_femme_public'), '')}} sont présent.e.s<br>
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->egalite_homme_femme', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'égalité homme femme", 'description' => "Décrivez l'égalité homme femme en quelques mots"])
                </p>
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
                    Le projet a fait évoluer l'image du quartier / territoire {{formatArray($place->get('blocs->impact_social->donnees->cadre_de_vie_image'), '')}},
                    {{formatArray($place->get('blocs->impact_social->donnees->cadre_de_vie_type'), '')}}
                  @endif
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->cadre_de_vie', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du cadre de vie", 'description' => "Décrivez le cadre de vie en quelques mots"])
                </p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->cadre_de_vie')])
                <br>
              @endif
              @if (formatArray($place->get('blocs->impact_social->donnees->entretien_des_espaces_effets'), '') !== "non, aucun effet" || isset($edit))
                <h3>Entretien des espaces</h3>
                <p>
                  @if (formatArray($place->get('blocs->impact_social->donnees->entretien_des_espaces_effets'), '') === "des effets positifs")
                    Le projet a permis d'améliorer {{ formatArray($place->get('blocs->impact_social->donnees->entretien_des_espaces_effets_positif_type'), ' , ') }}
                    @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->entretien_des_espaces_effets_positif_example', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'entretien des espaces", 'description' => "Décrivez l'entretien des espaces en quelques mots"])
                    @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->entretien_des_espaces_effets_positif_example')])
                  @else
                    Le projet a engendré {{ formatArray($place->get('blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_type'), ' , ') }}
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
              <h3>Services publiques et de proximités</h3>
              <p>
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
                    Le projet a permis de répondre à des besoins sociaux urgents du territoire : {{ formatArray($place->get('blocs->impact_social->donnees->services_publics_besoin_urgent'), '') }}
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
              <p>
                @if(formatArray($place->get('blocs->impact_social->donnees->innovation_publique_effet'), '') === "non")
                  La collaboration avec les partenaires publics et privés n'a pas fait évoluer leurs pratiques professionnelles
                @elseif (formatArray($place->get('blocs->impact_social->donnees->innovation_publique_effet'), '') === "cela a permis d'améliorer ou expérimenter de nouveaux modes de faire")
                  La collaboration avec les partenaires publics et privés a permis d'améliorer ou expérimenter de nouveaux modes de faire :
                  {{formatArray($place->get('blocs->impact_social->donnees->innovation_publique_type'), '')}}
                @else
                  La collaboration avec les partenaires publics et privés a permis d'améliorer ou expérimenter de nouveaux modes de faire, mais cela a créé une surcharge de travail, une réorganisation / a été difficile à mettre en oeuvre :
                  {{formatArray($place->get('blocs->impact_social->donnees->innovation_publique_type'), '')}}
                @endif

                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->innovation_publique', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'innovation_publique", 'description' => "Décrivez l'innovation publique en quelques mots"])
              </p>
              @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->innovation_publique')])
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
