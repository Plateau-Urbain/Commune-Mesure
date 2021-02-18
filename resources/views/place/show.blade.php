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
        <div id="presentation" class="hero is-large anchor">
            <section class="section">
              <h2 class="ribbon-banner is-5 has-text-centered">Présentation du lieu</h2>
              <div class="has-text-centered pt-2">
                <p><i class="fas fa-clock font-color-theme mr-1"></i>
                  <strong>Ouverture : </strong><span class="font-color-theme">En permanence</span>
                </p>
              </div>
              <div class="section pt-5" style="padding-bottom:0;">
                <div class="columns is-tablet">
                  <x-edit-section :edit="isset($edit)" section="bloc_gauche" :sections="$sections" class="column" :slug="$slug ?? false" :auth="$auth ?? false">
                    @include('partials.place.sections.bloc-gauche')
                  </x-edit-section>

                  <x-edit-section :edit="isset($edit)" section="bloc_milieu" :sections="$sections" class="column" :slug="$slug ?? false" :auth="$auth ?? false">
                    @include('partials.place.sections.bloc-milieu')
                  </x-edit-section>

                <x-edit-section :edit="isset($edit)" section="bloc_droite" :sections="$sections" class="column" :slug="$slug ?? false" :auth="$auth ?? false">
                  @include('partials.place.sections.bloc-droite')
                </x-edit-section>
              </div>
            </section>
          </div>
          <section>
            <div class="section" style="padding:0;">
              <div class="columns has-text-centered ">
                <x-edit-section :edit="isset($edit)" section="public" :sections="$sections" class="column" :slug="$slug ?? false" :auth="$auth ?? false">
                  @include('partials.place.sections.public')
                </x-edit-section>

                <x-edit-section :edit="isset($edit)" section="accessibilite" :sections="$sections" class="column" :slug="$slug ?? false" :auth="$auth ?? false">
                  @include('partials.place.sections.accessibilite')
                </x-edit-section>

                <x-edit-section :edit="isset($edit)" section="transport" :sections="$sections" class="column" :slug="$slug ?? false" :auth="$auth ?? false">
                  @include('partials.place.sections.transport')
                </x-edit-section>
              </div>
            </div>
          </section>

          <section class="section" id="valeurs">
          <x-edit-section :edit="isset($edit)" section="valeurs" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
            @include('partials.place.sections.values')
          </x-edit-section>
          </section>

            <section class="section" id="finances" >
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
              @include('partials.place.sections.impact-social')
            </section>

      <section class="section anchor" id="lieu_territoire">
        <x-edit-section :edit="isset($edit)" section="lieu_territoire" :sections="$sections" :slug="$slug ?? false" :auth="$auth ?? false">
          @include('partials.place.sections.territoire')
        </x-edit-section>
      </section>

    </div>
</div>

@if(isset($edit) && $edit) 
  @foreach($sections as $section)
    @include('components.modals.modalEdition',['section'=>$section->section])
  @endforeach
@endif
@endsection
