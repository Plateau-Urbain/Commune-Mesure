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
            </div>
            <div>
              <img class="rounded {{ !empty($place->get('blocs->impact_social->donnees->intensite_effets_individuels')) ? 'size-'.$place->get("blocs->impact_social->donnees->intensite_effets_individuels") : 'size-1' }}" src="{{ url('/images/EFFETS-perso.png') }}">
            </div>
          </a>

          <a href="#effets_collectifs" class="valeur collectif">
            <div class="text text--right">
              <h3>Effets<br> collectifs</h3>
            </div>
            <img class="rounded {{ !empty($place->get('blocs->impact_social->donnees->intensite_effets_collectifs')) ? 'size-'.$place->get("blocs->impact_social->donnees->intensite_effets_collectifs") : 'size-1' }}"" src="{{ url('/images/EFFETS-collectifs.png') }}">
          </a>

          <a href="#effets_territoriaux" class="valeur territorial reverse">
            <div class="text">
              <h3>Effets<br> territoriaux</h3>
            </div>
            <img class="rounded {{ !empty($place->get('blocs->impact_social->donnees->intensite_effets_territoriaux')) ? 'size-'.$place->get("blocs->impact_social->donnees->intensite_effets_territoriaux") : 'size-1' }}"" src="{{ url('/images/EFFETS-territoriaux.png') }}">
          </a>

          <a href="#effets_urbains" class="valeur urbain reverse">
            <div class="text">
              <h3>Effets sur<br> le projet urbain</h3>
            </div>
            <img class="rounded size-1" src="{{ url('/images/EFFETS-urbain.png') }}">
          </a>

          <div class="cloud-layer">
            <div class="cloud">
              @foreach (explode(',', $place->get("blocs->impact_social->donnees->mots_cles_effets_individuels")) as $key => $word)
                @if (!empty(trim($word)))
                  <span class="word word-{{$key}}">#{{trim($word)}}</span>
                @endif
              @endforeach
              @foreach (explode(',', $place->get("blocs->impact_social->donnees->mots_cles_effets_collectifs")) as $key => $word)
                @if (!empty(trim($word)))
                  <span class="word word-{{$key}}">#{{trim($word)}}</span>
                @endif
              @endforeach
              @foreach (explode(',', $place->get("blocs->impact_social->donnees->mots_cles_effets_territoriaux")) as $key => $word)
                @if (!empty(trim($word)))
                  <span class="word word-{{$key}}">#{{trim($word)}}</span>
                @endif
              @endforeach
            </div>
          </div>

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
                  Entre quels publics avez-vous pu observer des interactions sociales sur le site ?
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
                  Avez-vous pu observer un changement des conditions physiques, sociales ou psychiques chez les bénéficiaires du projet, qui puissent être directement lié au projet ?
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
                  Avez-vous mis en place des actions de formation, d’accompagnement à la création d’activité ou à l’emploi ?
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
                  De nouveaux projets ou actions (atelier, événement, marché...) imprévus et portés par les bénéficiaires ou occupants ont-il émergé dans le cadre du projet ?
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
                  Y-a-t-il des échanges, dons ou mutualisations entre personnes au sein du projet ?
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
                  Avez-vous pu observer la création de réseaux de personnes ?
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->reseaux', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du réseaux", 'description' => "Décrivez le réseaux en quelques mots"])
                </p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->reseaux')])
              </div>
            </div>
            @endif
            @if (!empty($place->get('blocs->impact_social->donnees->appartenance_exclusion')) || isset($edit))
            <div class="image-start">
              <img src="{{ url('/images/inclusion-exclusion.png') }}" alt="inclusion exclusion">
              <div>
                <h3>Sentiment d'inclusion ou d'exclusion</h3>
                <p>
                  Diriez-vous que certaines personnes se sentent faire partie d'un groupe, ou s'en sentent exclus ? Quelles sont les personnes qui pourraient se sentir exclues ?
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->appartenance_exclusion', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'appartenance et l'exclusion", 'description' => "Décrivez l'appartenance et l'exclusion en quelques mots"])
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
                  Diriez-vous qu'il y a plus, moins ou autant de femmes que d'hommes dans le lieu ?
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
                  Avez-vous l’impression que le projet a fait évoluer l’image du quartier ou du territoire ?
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->cadre_de_vie', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte du cadre de vie", 'description' => "Décrivez le cadre de vie en quelques mots"])
                </p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->cadre_de_vie')])
                <br>
              @endif
              @if (!empty($place->get('blocs->impact_social->donnees->entretien_des_espaces')) || isset($edit))
                <h3>Entretien des espaces</h3>
                <p>
                  Le projet a-t-il modifié la gestion urbaine du quartier par les services des collectivités ou de leurs partenaires (ramassage des ordures, propreté, entretien, sécurité...) ?
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->entretien_des_espaces', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'entretien des espaces", 'description' => "Décrivez l'entretien des espaces en quelques mots"])
                </p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->entretien_des_espaces')])
              @endif
            </div>
          </div>
          @if (!empty($place->get('blocs->impact_social->donnees->services_publics')) || isset($edit))
          <div class="image-start">
            <img src="{{ url('/images/quartier-service-proximite.png') }}" alt="service de proxmité">
            <div>
              <h3>Services publiques et de proximités</h3>
              <p>
                Le projet a-t-il permis de répondre à des besoins sociaux urgents du territoire ?
                  @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->services_publics', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte des services publics", 'description' => "Décrivez les services publics en quelques mots"])
              </p>
              @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->services_publics')])
            </div>
          </div>
          @endif
          @if (!empty($place->get('blocs->impact_social->donnees->innovation_publique')) || isset($edit))
          <div class="image-start">
            <img src="{{ url('/images/quartier-innovations.png') }}" alt="innovation publique">
            <div>
              <h3>Innovation publique</h3>
              <p>
                Avez-vous pu constater que vos modalités de collaboration avec les partenaires publics et privés ont fait évoluer leurs pratiques professionnelles ?
                @include('components.modals.modalEdition', ['chemin' => 'blocs->impact_social->donnees->innovation_publique', 'id_section' => '', 'action' => 'impacts.update', 'type' => 'text', 'titre' => "Modifier le texte de l'innovation_publique", 'description' => "Décrivez l'innovation publique en quelques mots"])
              </p>
              @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->innovation_publique')])
            </div>
          </div>
          @endif
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
