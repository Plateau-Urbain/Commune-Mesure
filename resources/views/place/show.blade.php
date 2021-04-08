@extends('layout')
@section('title')
  <h1 class="title header-title">
    {{ $place->get('name') }}
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
  <script src='https://d3js.org/d3.v4.min.js'></script> {{-- chart finance --}}
  @include('js.place.chart-place')
  @include('js.place.map-insee-js')
  @include('js.place.d3-doughnut-finance-js')
  @include('js.place.insee-chart-js')
  @include('js.place.modals')
@endsection

@section('content')
  @isset($edit)
  <div style="position: fixed;width: 100%;top: 50px; z-index: 999;display:inline-flex" class="has-background-warning">
    <div class="container">
      <p class="has-text-centered has-text-weight-bold py-2" style="margin:auto;">
      Vous êtes en mode édition. Revenir à la <a href="{{ route('place.show', ['slug' => $slug]) }}">page consultation du lieu</a>.
      </p>
    </div>
    <button
      <?php if($place->isPublish()):?>
          class="button is-danger is-light" title="Dé-publier le lieu">
          <a style='color: black'href="{{ route('place.publish', ['slug' => $slug, 'auth' => $auth]) }}">
            <span class="icon">
              <i class="fas fa-users-slash"></i>
            </span>
          </a>
      <?php else : ?>
        class="button" title="Publier le lieu">
        <a style='color: black'href="{{ route('place.publish', ['slug' => $slug, 'auth' => $auth]) }}">
          <span class="icon">
            <i class="fas fa-globe"></i>
          </span>
        </a>
      <?php endif ?>
    </button>
    <button style='margin: 0px 20px 0px 20px;'class="button is-success" disabled title="Télécharger le csv">
      <span class="icon">
        <i class="fas fa-download"></i>
      </span>
    </button>
    <span style="padding: 5px 20px 0px 20px;color:red;float:right" class=" has-text-right"><a href="{{ route('place.show', ['slug' => $slug]) }}"><i class='fas fa-times'></i></a></span>
  </div>
@endisset

<div class="columns is-gapless is-mobile" id="container">

  <div class="column is-full">

    <x-edit-section :edit="isset($edit)" section="presentation" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      <section class="section section-place " id="section01">
        <div>
          <div class="scroll-indicator" id="section01" data-scroll-indicator-title="Présentation"></div>
        </div>
        <h2 class="sous-banner is-5 has-text-centered">PRÉSENTATION DU LIEU</h2>
        <div class="has-text-centered pt-2">
          <p><i class="fas fa-clock font-color-theme mr-1"></i>
          <strong>Ouverture : </strong><span class="font-color-theme">En permanence</span>
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
      <section class="section section-place">
        <aside id="info-box" class="mb-2">
          <div>
            <div class="scroll-indicator" id="section02" data-scroll-indicator-title="Localisation"></div>
          </div>
          <div class='sous-banner sous-banner-localisation'>
            <h3 class="is-5 has-text-centered">LOCALISATION </h3>
            <a href="geo:{{ $place->get('blocs->data_territoire->donnees->geo->lat') }},{{ $place->get('blocs->data_territoire->donnees->geo->lon') }}">{{ $place->get('address->address') }}, {{ $place->get('address->postalcode') }} {{ $place->get('address->city') }}</a>
          </div>
          <div class="info-box-content">
              <div id="info-box-map" class="info-box-map"></div>
          </div>
        </aside>
        <div class="columns has-text-centered accessibilite">
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
      </x-edit-section>
    </section>

    <section class="section">
      <x-edit-section :edit="isset($edit)" section="valeurs" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
        <div>
          <div class="scroll-indicator" id="section03" data-scroll-indicator-title="Les valeurs"></div>
        </div>
        @include('partials.place.sections.values')
      </x-edit-section>
    </section>

    <section  class="section">
      <div class="columns">
        @php $class="" @endphp
        @if (!isset($edit) && (!$sections['moyens'] || !$sections['composition'] ))
          @php $class="is-6 is-offset-3" @endphp
        @endif

        <x-edit-section :edit="isset($edit)" section="moyens" :sections="$sections" :isEmpty="$isEmpty" class="column {{ $class }}" :slug="$slug ?? false" :auth="$auth ?? false">
          @if (!isset($edit) && (!$sections['composition']) || !$sections['composition'])
            <div>
              <div class="scroll-indicator" id="section04" data-scroll-indicator-title="Les moyens"></div>
            </div>
          @elseif(isset($edit))
            <div>
              <div class="scroll-indicator" id="section04" data-scroll-indicator-title="Les moyens / La composition"></div>
            </div>
          @elseif(!isset($edit) && ($sections['composition'] || $sections['composition']) && $sections['moyens'] || $sections['moyens'])
            <div>
              <div class="scroll-indicator" id="section04" data-scroll-indicator-title="Les moyens / La composition"></div>
            </div>
          @endif
          @include('partials.place.sections.moyens')
        </x-edit-section>

        <x-edit-section :edit="isset($edit)" section="composition" :sections="$sections" :isEmpty="$isEmpty" class="column {{ $class }}" :slug="$slug ?? false" :auth="$auth ?? false">
          @if (!isset($edit) && (!$sections['moyens'] || !$sections['moyens']))
            <div>
              <div class="scroll-indicator" id="section04" data-scroll-indicator-title="La composition"></div>
            </div>
          @endif
          @include('partials.place.sections.composition')
        </x-edit-section>
      </div>
    </section>

    <section  class="section">
      <x-edit-section :edit="isset($edit)" section="impact_social" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
        <div>
          <div class="scroll-indicator" id="section05" data-scroll-indicator-title="L'impact social"></div>
        </div>
        @include('partials.place.sections.impact-social')
      </x-edit-section>
    </section>

    <section class="section anchor">
      <x-edit-section :edit="isset($edit)" section="data_territoire" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
        <div>
          <div class="scroll-indicator" id="section06" data-scroll-indicator-title="Le territoire"></div>
        </div>
        @include('partials.place.sections.territoire')
      </x-edit-section>
    </section>
    <section class="section anchor">
      <x-edit-section :edit="isset($edit)" section="galerie" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
        @if(isset($edit))
          <span class="icon-edit">
            <a href="{{ route('place.editGalerie', ['slug' => $slug, 'auth' => $auth]) }}"> <i style="color:black" class="fa fa-pen modal-crayon" title="Éditer la section" style="position:absolute;margin-top:-13px;"></i></a>
          </span>
        @endif
        <div>
          <div class="scroll-indicator" id="section07" data-scroll-indicator-title="Galerie"></div>
        </div>
        @include('partials.place.sections.carousel')
      </x-edit-section>
    </section>
        </div>
  </div>
  <script type="text/javascript" src="/js/easyScrollDots.min.js"></script>

  <script>
    easyScrollDots({
          'fixedNav': true, // Set to true if you have a fixed nav.
          'fixedNavId': 'main-navbar', // Set to the id of your navigation element if 'fixedNav' is true (easyScrollDots will measure the height of the element).
          'fixedNavUpward': false, // Set to true if your nav is only sticky when the user is scrolling up (requires 'fixedNav' to be true and 'fixedNavId' to be a value).
          'offset': 50 // Set to the amount of pixels you wish to offset the scroll amount by.
        });
  </script>
@endsection
