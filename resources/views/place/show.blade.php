@extends('layout')
@section('title')
  <h1 class="title header-title">
    Le data panorama
    <br>
    de {{ $place->get('name') }}
  </h1>
  <h2 class="subtitle">
    {{ $place->get('address->city') }}
  </h2>
@endsection

@section('head_css')
  @parent
@endsection

@section('script_js')
  @parent
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> {{-- Graphs insee --}}
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script> {{-- animate on scroll impact --}}
  <script>AOS.init();</script>
  @include('js.place.insee-graph')
  @include('js.place.map-insee-js')
  @include('js.place.charts-doughnut')
  @include('js.place.modals')
@endsection

@section('content')
  @isset($edit)
  <div class="has-background-warning edit-banner">
    <div class="container">
      <p class="has-text-centered has-text-weight-bold py-2">
      Vous êtes en mode édition. Revenir à la <a href="{{ route('place.show', ['slug' => $slug]) }}">page consultation du lieu</a>.
      </p>
    </div>
    <button
      <?php if($place->isPublish()):?>
          class="button is-danger is-light" title="Dé-publier le lieu">
          <a class="has-text-black" href="{{ route('place.publish', ['slug' => $slug, 'auth' => $auth]) }}">
            <span class="icon">
              <i class="fa fa-users-slash"></i>
            </span>
          </a>
      <?php else : ?>
        class="button" title="Publier le lieu">
        <a class="has-text-black" href="{{ route('place.publish', ['slug' => $slug, 'auth' => $auth]) }}">
          <span class="icon">
            <i class="fa fa-globe"></i>
          </span>
        </a>
      <?php endif ?>
    </button>
    <a href="{{ route('place.csv', ['slug' => $slug, 'auth' => $auth]) }}">
      <button class="button is-success ml-4" title="Télécharger le csv">
        <span class="icon">
          <i class="fa fa-download"></i>
        </span>
      </button>
    </a>

    <span><a class="has-text-primary mx-4" href="{{ route('place.show', ['slug' => $slug]) }}"><i class='fas fa-times'></i></a></span>
  </div>
@endisset

<div class="columns is-gapless is-mobile" id="container">

  <div class="column is-full">

    <x-edit-section :edit="isset($edit)" section="presentation" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      <section class="section section-place " id="presentation">
        <div class="scroll-indicator" id="presentation" data-scroll-indicator-title="&nbsp;&nbsp;PRÉSENTATION"></div>
        <h2 class="sous-banner is-5 has-text-centered">PRÉSENTATION DU LIEU</h2>
        <div class="has-text-centered pt-2">
          <p>
          @if (($link = $place->get('reseaux_sociaux->donnees->web')) || isset($edit))
            <i class="fa fa-globe has-text-primary mr-1"></i> <span class="has-text-weight-bold">Site web :</span> <a href="{{ $link }}">{{ $link }}</a>
          @endif
          @if(isset($edit))
            @include('components.modals.modalEdition', ['chemin' => 'reseaux_sociaux->donnees->web', 'id_section' => 'presentation', 'type' => 'text', 'titre' => "Modifier le site web", "description" => "Le site internet du lieu"])
          @endif
          </p>

          <p><i class="fas fa-clock font-color-theme mr-1"></i>
          <strong>Ouverture  : </strong>
            <span class="font-color-theme">{{ $place->getOuverture()}}</span>
          @if(isset($edit))
             @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->ouverture','id_section'=>'presentation','type' => 'select','titre'=>"Modifier l'ouverture","description"=>"Les modalités d'ouverture du lieu"])
          @endif
          </p>
        </div>
        <div class="section pt-5" style="padding-bottom:0;">
          <div class="columns is-tablet">
            <div class="column">
              @include('partials.place.sections.bloc-gauche')
            </div>
            <div class="column">
              @include('partials.place.sections.bloc-milieu')
            </div>
            <div class="column">
              @include('partials.place.sections.bloc-droite')
            </div>
          </div>
        </section>
    </x-edit-section>

    <x-edit-section :edit="isset($edit)" section="accessibilite" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      <section class="fond-bleu">
        <div class="scroll-indicator" id="accessibilite" data-scroll-indicator-title="&nbsp;&nbsp;LOCALISATION"></div>
        <div class="columns has-text-centered accessibilite" style='margin:0'>
          @if(!$place->isEmptyAccessibilityBySection('publics') && !isset($edit) || isset($edit))
            <div class="column">
              @include('partials.place.sections.public')
            </div>
          @endif
          @if(!$place->isEmptyAccessibilityBySection('accessibilite')&& !isset($edit) || isset($edit))
            <div class="column">
              @include('partials.place.sections.accessibilite')
            </div>
          @endif
          @if(!$place->isEmptyAccessibilityBySection('transports') && !isset($edit) || isset($edit))
            <div class="column">
              @include('partials.place.sections.transport')
            </div>
          @endif
        </div>
      </section>
      <section class="section section-place">
        <div class='sous-banner sous-banner-localisation'>
          <h3 class="is-5 has-text-centered">LOCALISATION </h3>
          <a href="geo:{{ $place->get('blocs->data_territoire->donnees->geo->lat') }},{{ $place->get('blocs->data_territoire->donnees->geo->lon') }}">{{ $place->get('address->address') }}, {{ $place->get('address->postalcode') }} {{ $place->get('address->city') }}</a>
        </div>
        <div>
            <div id="section-map" class="map-fullwidth"></div>
        </div>
      </section>
    </x-edit-section>

    @if((!isset($edit) && ($sections['moyens']) || $sections['composition']) || isset($edit))
      <section class="section section-place">
        <div class="columns">
          @php $class="" @endphp
          @if (!isset($edit) && (!$sections['moyens'] || !$sections['composition'] ))
            @php $class="is-6 is-offset-3" @endphp
          @endif

          <x-edit-section :edit="isset($edit)" section="moyens" :sections="$sections" :isEmpty="$isEmpty" class="column {{ $class }}" :slug="$slug ?? false" :auth="$auth ?? false">
            @if (!isset($edit) && !$sections['composition'])
                <div class="scroll-indicator" id="moyens" data-scroll-indicator-title="&nbsp;&nbsp;LES MOYENS"></div>
                <div id="composition"></div>
            @elseif(isset($edit) || (!isset($edit) && $sections['composition'] && $sections['moyens'] ))
                <div class="scroll-indicator" id="moyens" data-scroll-indicator-title="&nbsp;&nbsp;MOYENS / COMPOSITION"></div>
                <div id="composition"></div>
            @endif
            @include('partials.place.sections.moyens')
          </x-edit-section>
          <x-edit-section :edit="isset($edit)" section="composition" :sections="$sections" :isEmpty="$isEmpty" class="column border-composition {{ $class }}" :slug="$slug ?? false" :auth="$auth ?? false">
            @if (!isset($edit) && (!$sections['moyens']))
              <div class="scroll-indicator" id="moyens" data-scroll-indicator-title="&nbsp;&nbsp;LA COMPOSITION"></div>
            @endif
            @include('partials.place.sections.composition')
          </x-edit-section>

        </div>
      </section>
    @endif

    <x-edit-section :edit="isset($edit)" section="valeurs" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      <section class="section section-place">
        <div class='column'>
            <div class="scroll-indicator" id="valeurs" data-scroll-indicator-title="&nbsp;&nbsp;LES VALEURS PORTÉES"></div>
            @include('partials.place.sections.values')
        <div>
      </section>
    </x-edit-section>

    <x-edit-section :edit="isset($edit)" section="impact_social" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
        <section  class="section section-place fond-bleu" style="padding-bottom: 100px;">
        <div class="scroll-indicator" id="impact_social" data-scroll-indicator-title="&nbsp;&nbsp;L'IMPACT SOCIAL"></div>
        @include('partials.place.sections.impact-social')
        </section>
    </x-edit-section>


    <x-edit-section :edit="isset($edit)" section="data_territoire" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      <section class="section anchor section-place">
        <div class="scroll-indicator" id="data_territoire" data-scroll-indicator-title="&nbsp;&nbsp;LE TERRITOIRE"></div>
        @include('partials.place.sections.territoire')
      </section>
    </x-edit-section>
    <x-edit-section :edit="isset($edit)" section="galerie" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      <section class="section anchor section-place">
          <div class="scroll-indicator" id="galerie" data-scroll-indicator-title="&nbsp;&nbsp;GALERIE"></div>
          @include('partials.place.sections.carousel')
      </section>
    </x-edit-section>
        </div>
  </div>
  <script type="text/javascript" src="{{ url('/js/easyScrollDots.min.js') }}"></script>

  <script>
    easyScrollDots({
          'fixedNav': true, // Set to true if you have a fixed nav.
          'fixedNavId': 'main-header', // Set to the id of your navigation element if 'fixedNav' is true (easyScrollDots will measure the height of the element).
          'fixedNavUpward': false, // Set to true if your nav is only sticky when the user is scrolling up (requires 'fixedNav' to be true and 'fixedNavId' to be a value).
          'offset': 50 // Set to the amount of pixels you wish to offset the scroll amount by.
        });
  </script>
@endsection
