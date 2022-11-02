@extends('layout')

@section('title')
  {{-- vide --}}
@endsection

@section('header.submenu')
  @empty($edit)
  <div id="sticky" class="sticky">
    <div class="container has-text-centered app-name">
      <h1 class="title header-title">
        {{ $place->get('name') }} <span class="sticky-separator">></span> <span id="sticky-section"></span>
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
  @include('js.place.modals')
  @include('js.place.d3')
  @include('js.place.scrollspy')

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

  <script>
    let updatePavement = function() {
      let presentation = document.querySelector('#presentation');
      let pavementSVGTopRect = document.querySelector('#pavement-svg-top').getBoundingClientRect();
      let pavementTop = document.querySelector('#pavement-top');
      pavementTop.style.top = ((Math.round((pavementSVGTopRect.top - presentation.getBoundingClientRect().top) * 10 ) / 10) - 19) + 'px';
      pavementTop.style.display = 'block';

      let pavementSVGBottomRect = document.querySelector('#pavement-svg-bottom').getBoundingClientRect();
      let pavementBottom = document.querySelector('#pavement-bottom');
      pavementBottom.style.top = ((Math.round((pavementSVGBottomRect.top - presentation.getBoundingClientRect().top) * 10 ) / 10) - 19) + 'px';
      pavementBottom.style.display = 'block';
    }

    @empty($edit)
      updatePavement();

      window.addEventListener('resize', function(e) {
        updatePavement();
      });
    @endempty
  </script>
@endsection

@section('content')
  @isset($edit)
    @include('partials.place.sticky-edit')
  @endisset

<div id="container" @isset($edit) style="padding-top:50px" @endisset>
  <div data-spy="Le lieu">
    <x-edit-section :edit="isset($edit)" section="presentation" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      @include('partials.place.sections.presentation')
    </x-edit-section>

    <x-edit-section :edit="isset($edit)" section="accessibilite" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      @include('partials.place.sections.localisation')
    </x-edit-section>
  </div>

  <div data-spy="La programmation">
    <x-edit-section :edit="isset($edit)" section="valeurs" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      @include('partials.place.sections.valeurs')
    </x-edit-section>
  </div>

  <div data-spy="Les acteur.ices">
    <x-edit-section :edit="isset($edit)" section="composition" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      @include('partials.place.sections.composition')
    </x-edit-section>

    <x-edit-section :edit="isset($edit)" section="valeurs" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      @include('partials.place.sections.acteurices')
    </x-edit-section>
  </div>

  <div data-spy="Les moyens">
    <x-edit-section :edit="isset($edit)" section="moyens" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      @include('partials.place.sections.moyens')
    </x-edit-section>
  </div>

  <div data-spy="Les effets">
    <x-edit-section :edit="isset($edit)" section="impact_social" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
        @include('partials.place.sections.impact-social')
    </x-edit-section>
  </div>
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
