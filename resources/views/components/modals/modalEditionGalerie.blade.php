@if(!isset($edit))
  @php return @endphp
@endif
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
  @include('js.place.insee-graph')
  @include('js.place.map-insee-js')
  @include('js.place.charts-doughnut')
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
      <section class="section section-place " id="presentation">
        <div>
          <div class="scroll-indicator" id="presentation" data-scroll-indicator-title="PRESENTATION"></div>
        </div>
        <h2 class="sous-banner is-5 has-text-centered">PRÉSENTATION DU LIEU</h2>
        <div class="has-text-centered pt-2">
          <strong> Tags : </strong>
          @foreach($place->getData()->tags as $tag)
            <li class="tags">{{$tag}}</li>
          @endforeach
          @if(isset($edit))
             @include('components.modals.modalEdition',['chemin'=>'tags','id_section'=>'presentaion','type' => 'text','titre'=>"Modifier les tags",'description'=>"Les mots-clefs qui identifient aisément le lieu lors d'une recherche"])
          @endif
          <p><i class="fas fa-clock font-color-theme mr-1"></i>
          <strong>Ouverture  : </strong>
            <span class="font-color-theme">{{ $place->getOuverture()}}</span>
          @if(isset($edit))
             @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->ouverture','id_section'=>'presentation','type' => 'select','titre'=>"Modifier l'ouverture"])
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


    <div class="modal is-active" id="{{$chemin}}" style="z-index: 100000;">
      <div class="modal-background" ></div>
      <div class="modal-card">

        <header class="modal-card-head">
          <div class="modal-card-title">
            <h2>
              Modifier la galerie
             </h2>
          </div>
           <a href="{{ route('place.edit', ['slug' => $place->getSlug(), 'auth' => $auths[$place->getSlug()]])}}#galerie"><button class="delete modal-croix" aria-label="close"></button></a>
           <br>
        </header>

        <form method="POST" action="{{route('place.updateGalerie',['slug' => $slug, 'auth' => $auth , 'chemin'=>$chemin])}}" enctype="multipart/form-data">
            <section class="modal-card-body">
                <small style='margin-left:10px'>
                   Des photos du lieu !
                </small>
                <hr style='border:1px solid #dbdbdb'>

              @php $array_photos = $place->getPhotos();@endphp
                @unless(empty($array_photos))
                <div class="carousel" data-navigation=1>
                  @foreach($array_photos as $photo)
                  @if($photo)
                    <div>
                      <button name="supprimer" style="z-index:1000;position:absolute;" class="button pull-right is-danger" type="submit" value="{{ array_search($photo,$array_photos) }}"><i class="fas fa-times"></i></button>
                      <figure class="image is-covered">
                          <img src="/images/lieux/{{ $photo }}">
                      </figure>
                    </div>
                  @endif
                  @endforeach
                </div>
                @else
                  <div>
                    <p>Il n'y a pas encore de photo.</p>
                  </div>
                @endunless
              <br>
            <footer class="modal-card-foot" style="border-bottom: 1px solid #dbdbdb" >
              <span class="container">
                <label>Ajouter une image : </label><input id='image' type='file' accept="image/jpeg" name='image'/>
                <button name="ajouter" class="button is-success" type="submit" value='ajouter'>Ajouter</button>
              </span>
            </footer>
            <br>
            <span class="container">
              <span class="field is-grouped is-grouped-left">
                <a href="{{ route('place.edit', ['slug' => $place->getSlug(), 'auth' => $auths[$place->getSlug()]]) }}#galerie"><input class="button" type='button' value="Fermer"/></button></a>
              </span>
            </span>

        </form>
    </div>
    </div>



    <x-edit-section :edit="isset($edit)" section="accessibilite" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      <section class="section section-place">
        <aside id="info-box" class="mb-2">
          <div>
            <div class="scroll-indicator" id="accessibilite" data-scroll-indicator-title="Localisation"></div>
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
      </section>
    </x-edit-section>
    <x-edit-section :edit="isset($edit)" section="valeurs" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
      <section class="section section-place">
        <div class='column'>
            <div>
              <div class="scroll-indicator" id="valeurs" data-scroll-indicator-title="Les valeurs"></div>
            </div>
            @include('partials.place.sections.values')
        <div>
      </section>
    </x-edit-section>

    <section class="section section-place">
      <div class="columns">
        @php $class="" @endphp
        @if (!isset($edit) && (!$sections['moyens'] || !$sections['composition'] ))
          @php $class="is-6 is-offset-3" @endphp
        @endif
        <x-edit-section :edit="isset($edit)" section="moyens" :sections="$sections" :isEmpty="$isEmpty" class="column {{ $class }}" :slug="$slug ?? false" :auth="$auth ?? false">
          @if (!isset($edit) && (!$sections['composition']) || !$sections['composition'])
            <div>
              <div class="scroll-indicator" id="moyens" data-scroll-indicator-title="Les moyens"></div>
            </div>
          @elseif(isset($edit))
            <div>
              <div class="scroll-indicator" id="moyens" data-scroll-indicator-title="Les moyens / La composition"></div>
            </div>
          @elseif(!isset($edit) && ($sections['composition'] || $sections['composition']) && $sections['moyens'] || $sections['moyens'])
            <div>
              <div class="scroll-indicator" id="moyens" data-scroll-indicator-title="Les moyens / La composition"></div>
            </div>
          @endif
          @include('partials.place.sections.moyens')
        </x-edit-section>

        <x-edit-section :edit="isset($edit)" section="composition" :sections="$sections" :isEmpty="$isEmpty" class="column border-composition {{ $class }}" :slug="$slug ?? false" :auth="$auth ?? false">
          @if (!isset($edit) && (!$sections['moyens'] || !$sections['moyens']))
            <div>
              <div class="scroll-indicator" id="composition" data-scroll-indicator-title="La composition"></div>
            </div>
          @endif
          @include('partials.place.sections.composition')
        </x-edit-section>
      </div>
    </section>
    <x-edit-section :edit="isset($edit)" section="impact_social" :sections="$sections" :isEmpty="$isEmpty" :slug="$slug ?? false" :auth="$auth ?? false">
        <section  class="section section-place">
        <div>
          <div class="scroll-indicator" id="impact_social" data-scroll-indicator-title="L'impact social"></div>
        </div>
        @include('partials.place.sections.impact-social')
        </section>
    </x-edit-section>
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
