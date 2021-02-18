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

<div class="columns is-gapless" id="container">
    <div class="column is-2">
        @include('partials.place.place-menu')
    </div>

    <div class="column">
      <section class="section">
        <x-edit-section :edit="isset($edit)" section="bloc_gauche" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
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
          @include('components.modals.modalEdition',['chemin'=>'opening->publics'])
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

      <section class="section" id="valeurs">
        <x-edit-section :edit="isset($edit)" section="valeurs" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
          @include('partials.place.sections.values')
        </x-edit-section>
      </section>

      <section class="section" id="finances">
        <div class="columns">
          @php $class="" @endphp
          @if (!isset($edit) && (!$sections->has('composition') || !$sections->get('composition')))
            @php $class="is-6 is-offset-3" @endphp
          @endif
          <x-edit-section :edit="isset($edit)" section="moyens" :sections="$sections" class="column {{ $class }}" :slug="$slug ?? false" :auth="$auth ?? false">
            @include('partials.place.sections.moyens')
          </x-edit-section>

          @php $class="" @endphp
          @if (!isset($edit) && (!$sections->has('moyens') || !$sections->get('moyens')))
            @php $class="is-6 is-offset-3" @endphp
          @endif
          <x-edit-section :edit="isset($edit)" section="composition" :sections="$sections" class="column {{ $class }}" :slug="$slug ?? false" :auth="$auth ?? false">
            @include('partials.place.sections.composition')
          </x-edit-section>
        </div>
      </section>

      <section class="section" id="impact-social">
        <x-edit-section :edit="isset($edit)" section="reseau" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
          @include('partials.place.sections.impact-social')
        </x-edit-section>
      </section>

      <section class="section anchor" id="lieu_territoire">
        <x-edit-section :edit="isset($edit)" section="lieu_territoire" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
          @include('partials.place.sections.territoire')
        </x-edit-section>
      </section>

      <section class="section anchor" id="carousel">
        @include('partials.place.sections.carousel')
      </section>
    </div>
</div>

@endsection
