@if(!$place->publish && !isset($edit))
  @include('partials.place.not-published')
@else
  @extends('layout')
  @section('title')
  <h1 class="title header-title">
  {{ $place->name }}
  </h1>
  <h2 class="subtitle">
      {{ $place->address->city }}
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
      @include('js.place.value-bubbles')
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
      <button <?php if($place->publish):?> class="button is-danger" title="Dé-publier le lieu" <?php else : ?> class="button is-success" title="Publier le lieu" <?php endif ?> ><a style="color:black"  href="{{ route('place.publish', ['slug' => $place->name, 'auth' => $auth]) }}"><span class="icon"><i class="fas fa-share-square"></i></span></a></button>
      <button style='margin: 0px 20px 0px 20px;'class="button is-success" disabled title="Télécharger le csv">
          <span class="icon">
            <i class="fas fa-download"></i>
          </span>
      </button>
      <span style="padding: 5px 20px 0px 20px;color:red;float:right" class=" has-text-right"><a href="{{ route('place.show', ['slug' => $slug]) }}"><i class='fas fa-times'></i></a></span>
    </div>
    @endisset

      <div class="columns is-gapless is-mobile" id="container">
        <div class="column is-2">
               @include('partials.place.place-menu')
           </div>
          <div class="column">

            <section class="section " id="section01">
              <x-edit-section :edit="isset($edit)" section="bloc_gauche" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
                <div>
                    <div class="scroll-indicator" id="section01" data-scroll-indicator-title="Présentation"></div>
                </div>
                <h2 class="ribbon-banner is-5 has-text-centered">Présentation du lieu</h2>
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
              </x-edit-section>
            </section>

            <section class="section">
              <x-edit-section :edit="isset($edit)" section="public" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
                @include('components.modals.modalEdition',['chemin'=>'opening', 'type' => 'checkbox'])
                <div class="columns has-text-centered">
                  <div class="column">
                    @include('partials.place.sections.public')
                  </div>

                  <div class="column">
                    @include('partials.place.sections.accessibilite')
                  </div>

                  <div class="column">
                    @include('partials.place.sections.transport')
                  </div>
                </div>
              </x-edit-section>
            </section>

            <section class="section">
              <x-edit-section :edit="isset($edit)" section="valeurs" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
                <div>
                    <div class="scroll-indicator" id="section02" data-scroll-indicator-title="Les valeurs"></div>
                </div>
                @include('partials.place.sections.values')
              </x-edit-section>
            </section>

            <section  class="section">
              <div class="columns">
                @php $class="" @endphp
                @if (!isset($edit) && (!$sections->has('composition') || !$sections->get('composition')))
                  @php $class="is-6 is-offset-3" @endphp
                @endif

                <x-edit-section :edit="isset($edit)" section="moyens" :sections="$sections" class="column {{ $class }}" :slug="$slug ?? false" :auth="$auth ?? false">
                  @if (!isset($edit) && (!$sections->has('composition') || !$sections->get('composition')))
                    <div>
                        <div class="scroll-indicator" id="section03" data-scroll-indicator-title="Les moyens"></div>
                    </div>
                  @elseif(isset($edit))
                  <div>
                      <div class="scroll-indicator" id="section03" data-scroll-indicator-title="Les moyens / La composition"></div>
                  </div>
                  @elseif(!isset($edit) && ($sections->has('composition') || $sections->get('composition')) && $sections->has('moyens') || $sections->get('moyens'))
                  <div>
                      <div class="scroll-indicator" id="section03" data-scroll-indicator-title="Les moyens / La composition"></div>
                  </div>
                  @endif
                  @include('partials.place.sections.moyens')
                </x-edit-section>

                @php $class="" @endphp
                @if (!isset($edit) && (!$sections->has('moyens') || !$sections->get('moyens')))
                  @php $class="is-6 is-offset-3" @endphp
                @endif
                <x-edit-section :edit="isset($edit)" section="composition" :sections="$sections" class="column {{ $class }}" :slug="$slug ?? false" :auth="$auth ?? false">

                  @if (!isset($edit) && (!$sections->has('moyens') || !$sections->get('moyens')))
                  <div>
                      <div class="scroll-indicator" id="section03" data-scroll-indicator-title="La composition"></div>
                  </div>
                  @endif
                  @include('partials.place.sections.composition')
                </x-edit-section>
              </div>
            </section>

            <section  class="section">
              <x-edit-section :edit="isset($edit)" section="reseau" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
                <div>
                    <div class="scroll-indicator" id="section04" data-scroll-indicator-title="L'impact social"></div>
                </div>
                @include('partials.place.sections.impact-social')
              </x-edit-section>
            </section>

            <section class="section anchor">
              <x-edit-section :edit="isset($edit)" section="lieu_territoire" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
                <div>
                    <div class="scroll-indicator" id="section05" data-scroll-indicator-title="Le territoire"></div>
                </div>
                @include('partials.place.sections.territoire')
              </x-edit-section>
            </section>
            <section class="section anchor">
              <x-edit-section :edit="isset($edit)" section="gallerie" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
                <div>
                    <div class="scroll-indicator" id="section06" data-scroll-indicator-title="Galerie"></div>
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

@endif
