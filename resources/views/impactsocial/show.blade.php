@extends('impactsocial.layout')

@section('meta_share')
@include('partials.place.meta.opengraph')
@include('partials.place.meta.twitter')
@endsection

@section('script_js')
@parent
  <script src="{{ url('/js/readmore.js') }}"></script>
@endsection

@section('content')

<div id="impact-page">
  <div class="columns is-gapless is-mobile" id="container">

    <div class="column is-full">
      <section id="sommaire">
        <div class="container">
          <div class="valeur individuel">
            <div class="text text--right">
              <h3>Effets<br> individuels</h3>
              <p>+++<span>++</span></p>
            </div>
            <div>
              <img class="rounded" src="{{ url('/images/EFFETS-perso.png') }}">
            </div>
          </div>

          <div class="valeur collectif">
            <div class="text text--right">
              <h3>Effets<br> collectifs</h3>
              <p>+++<span>++</span></p>
            </div>
            <img class="rounded" src="{{ url('/images/EFFETS-collectifs.png') }}">
          </div>

          <div class="valeur territorial reverse">
            <div class="text">
              <h3>Effets<br> territoriaux</h3>
              <p>+++<span>++</span></p>
            </div>
            <img class="rounded" src="{{ url('/images/EFFETS-territoriaux.png') }}">
          </div>

          <div class="valeur urbain reverse">
            <div class="text">
              <h3>Effets sur<br> le projet urbain</h3>
              <p>+++<span>++</span></p>
            </div>
            <img class="rounded" src="{{ url('/images/EFFETS-urbain.png') }}">
          </div>

          <img src="{{ url('/images/illustration-sommaire.png') }}" alt="sommaire">
        </div>
      </section>

      <section>
        <div class="custom-background">
          <h2 class="margin-image">effets individuels</h2>
          <div>
            <div class="image-start">
              <img src="{{ url('/images/individuel-lien-social.png') }}" alt="lien individuel">
              <div>
                <h3>Lien social</h3>
                <p>Interactions sociales entre voisin.e.s du quartier et associations ou entreprises locales lors d’évènements grand public de manière ponctuelle</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->lien_social')])
              </div>
            </div>
            <div class="image-start">
              <img src="{{ url('/images/sante.png') }}" alt="santé">
              <div>
                <h3>Santé</h3>
                <p>Certaines personnes ont paru se sentir mieux dans leurs relations avec les autres, ont fait part d'une plus grande confiance en eux.</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->sante_bien_être')])
              </div>
            </div>
            <div class="image-start">
              <img src="{{ url('/images/individuel-insertion-pro.png') }}" alt="insertion professionnelle">
              <div>
                <h3>Insertion professionnelle</h3>
                <p>17 participants aux actions de formation ou d’accompagnement à l’activité ou à l’emploi.</p> 
                <ul>
                  <li>- des diplômes obtenus</li>
                  <li>- 3 personnes qui gagnent en confiance en elle ou en l’avenir</li>
                </ul>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->insertion_professionnelle')])
              </div>
            </div>
            <div class="image-start">
              <img src="{{ url('/images/individuel-capacite-agir.png') }}" alt="capacité à agir">
              <div>
                <h3>Capacité à agir</h3>
                <p>5 nouveaux projets ou actions portés par des bénévoles et des résident.e.s</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->capacite_agir')])
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="gray-background">
        <div>
          <h2 class="orange center">effets collectifs</h2>
          <div class="row">
            <div class="image-start">
              <img src="{{ url('/images/collectif-solidarite.png') }}" alt="collectif solidarite">
              <div>
                <h3>Solidarité</h3>
                <p>Echanges de petits services, compétences et biens entre bénévoles, visiteurs et visiteuses et acteurs du quartier, association ou entreprise locales.</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->solidarite')])
              </div>
            </div>
            <div class="image-start">
              <img src="{{ url('/images/collectif-reseau.png') }}" alt="effets collectifs">
              <div>
                <h3>Réseau de personnes</h3>
                <p>Création de réseaux de personnes entre voisin.e.s du quartier, acteurs et actrices du quartier, associations ou entreprises locales et occupant.e.s du site autour d'un projet ou d'une action.</span>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->reseaux')])
              </div>
            </div>

            <div class="image-start">
              <img src="{{ url('/images/inclusion-exclusion.png') }}" alt="inclusion exclusion">
              <div>
                <h3>Sentiment d'inclusion ou d'exclusion</h3>
                <p>Certaines personnes se sentent à l’aise avec le projet, les gens sont fédérés autour du lieu.</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->appartenance_exclusion')])
              </div>
            </div>

            <div class="image-start">
              <img src="{{ url('/images/collectif-egalite.png') }}" alt="collectif solidarite">
              <div>
                <h3>égalité femmes/hommes</h3>
                <p>l'équipe de gestion et animation du lieu les dirigeants les résident.e.s et les occupants les publics.</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->egalite_homme_femme')])
              </div>
            </div>
          </div>
        </div>
      </section>

      <section>
        <div>
          <div class="half-image">
            <div>
              <img src="{{ url('/images/quartier-territoire-cadre-vie.png') }}" alt="cadre de vie">
            </div>
            <div>
              <h2 class="quartier">effets sur le quartier et le territoire</h2>
              <h3>Cadre de vie et attractivité du quartier</h3>
              <p>
                Le projet a fait évoluer le quartier de manière positive, il a fait émerger une nouvelle identité et a permis d'en faire une nouvelle destination.
              </p>
              <br>
              <p>
                L'accessibilité des espaces à tou.te.s (sentiment d'espaces plus mixtes du point du vue du genre et des groupes sociaux, minorités mieux représentées, espaces sécurisés...) et la mixité d'usages (marcher, s'asseoir, jouer, faire du sport, regarder, se rencontrer, jardiner...) sont des effets positif sur les espaces extérieurs du quartier ou l'environnement du site.
              </p>
              <br>
              <h3>Entretien des espaces</h3>
              <p>Le projet a permis d'améliorer la gestion urbaine par les services (ramassage des ordures, propreté, entretien, sécurité...).</p>
            </div>
          </div>
          <div>
            <div class="image-start">
              <img src="{{ url('/images/quartier-service-proximite.png') }}" alt="service de proxmité">
              <div>
                <h3>Services publiques et de proximités</h3>
                <p>Le projet a permis de répondre à des besoins sociaux urgents du territoire en services de proximité (conciergerie, recyclerie, épicerie solidaire...)</p>
                @include('impactsocial.partials.quote', ['text' => $place->get('blocs->impact_social->donnees->services_publics')])
              </div>
            </div>
          </div>
          <div>
            <div class="image-start">
              <img src="{{ url('/images/quartier-innovations.png') }}" alt="innovation publique">
              <div>
                <h3>Innovation publique</h3>
                <p>Nous avons pu constater que la collaboration avec les partenaires publics et privés a permis d 'améliorer ou expérimenter de nouveaux modes de faire.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="blue-background">
        <div>
          <div class="half-image">
            <div>
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
      </section>

    </div>
  </div>
</div>
@endsection