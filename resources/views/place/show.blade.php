@extends('layout')

@section('title')
  {{-- vide --}}
@endsection

@section('header.submenu')
  @empty($edit)
  <div id="sticky" class="sticky">
    <div class="container has-text-centered app-name">
      <h1 class="title header-title">
        {{ $place->get('name') }} <span class="sticky-separator">></span> <span class="sticky-section"></span>
      </h1>
    </div>
  </div>
  @endempty
@endsection

@section('meta_share')
  @include('partials.place.meta.opengraph')
  @include('partials.place.meta.twitter')
@endsection

@section('script_js')
  @parent
  @include('js.place.insee-graph')
  @include('js.place.map-insee-js')
  @include('js.place.modals')
  @include('js.place.d3')
  @include('js.place.scrollspy')

  <script type="text/javascript" src="{{ url('/js/easyScrollDots.min.js') }}"></script>

  <script>
    easyScrollDots({
          'fixedNav': true, // Set to true if you have a fixed nav.
          'fixedNavId': 'main-header', // Set to the id of your navigation element if 'fixedNav' is true (easyScrollDots will measure the height of the element).
          'fixedNavUpward': false, // Set to true if your nav is only sticky when the user is scrolling up (requires 'fixedNav' to be true and 'fixedNavId' to be a value).
          'offset': 50 // Set to the amount of pixels you wish to offset the scroll amount by.
        });
  </script>

  @isset($edit)
    <script>
      const popupHelpOpener = document.getElementById('modal-help-btn')
      const popupHelp = document.getElementById(popupHelpOpener.dataset.modal)
      const storage = window.localStorage
      if (! storage.getItem('_admin_help_popup_opened')) {
        popupHelp.classList.add('is-active')
        storage.setItem('_admin_help_popup_opened', Date())
      }
    </script>
  @endisset
@endsection

@section('content')
  @isset($edit)
    @include('partials.place.sticky-edit')
  @endisset

<div id="container" @isset($edit) style="padding-top:50px" @endisset>
    <x-edit-section :edit="isset($edit)" section="presentation" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      @include('partials.place.sections.presentation')
    </x-edit-section>

    <x-edit-section :edit="isset($edit)" section="accessibilite" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      @include('partials.place.sections.localisation')
    </x-edit-section>

    <x-edit-section :edit="isset($edit)" section="valeurs" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      @include('partials.place.sections.valeurs')
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
      </section>
    </x-edit-section>
  </div>

  @isset($edit)
  <div class="modal" id="modal-help" style="z-index: 100000;">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <h2 class="modal-card-title">Aide</h2>
        <button class="delete modal-croix" aria-label="Close"></button>
      </header>
      <section class="modal-card-body">
        <div class="content">
          <h3>Bienvenue sur le datapanorama de votre lieu !</h3>
          <p>Il vous propose des visualisations de certaines des données que vous avez renseignées dans le questionnaire.</br> Quelques informations pour vous aider à mieux naviguer sur la page et à éditer vos informations :</p>
        <h6>Sens des icônes de la page :</h6>
        <ul>
          <li><i class="fa fa-eye has-text-primary" aria-label="Icone oeil" role="icone"></i> : Section visible dans la page publique. Cliquer pour cacher.</li>
          <li><i class="fa fa-eye-slash has-text-primary" aria-label="Icone oeil" role="icone"></i> : Section non visible dans la page publique. Cliquer pour rendre visible.</li>
          <li><i class="fa fa-exclamation-triangle has-text-warning-dark" aria-label="Icone warning" role="icone"></i> : La section n'a pas de donnée et ne sera pas affichée.</li>
          <li><i class="fa fa-pen" aria-label="Icone crayon" role="icone"></i> : Édition de l'information.</li>
        </ul>
        <h6>Sens des icônes de la barre d'édition :</h6>
        <ul>
          <li><i class="fa fa-globe" aria-label="Icone publier" role="icone"></i> : Publier le lieu.</li>
          <li><i class="fa fa-users-slash" aria-label="Icone depublier" role="icone"></i> : Dépublier le lieu.</li>
          <li><i class="fa fa-download has-background-success p-1 has-text-white" aria-label="Icone téléchargement" role="icone"></i> : Télécharger les données du lieu.</li>
          <li><i class="fa fa-question has-background-info p-1 has-text-white" aria-label="Icone aide" role="icone"></i> : Affiche cette aide.</li>
        </ul>
        <p>N'oubliez pas que vous pouvez modifier votre datapanorama à tout moment, même après sa publication.</p>
        </div>
      </section>
    </div>
  </div>
  @endisset
@endsection
