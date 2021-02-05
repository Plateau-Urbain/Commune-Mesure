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
                  <x-edit-section :edit="isset($edit)" section="bloc_gauche" :sections="$sections" class="column">
                    @isset($edit)
                    <x-slot name="url">
                      <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'bloc_gauche']) }}">
                    </x-slot>
                    @endisset

                    @include('partials.place.sections.bloc-gauche')
                  </x-edit-section>

                  <x-edit-section :edit="isset($edit)" section="bloc_milieu" :sections="$sections" class="column">
                    @isset($edit)
                    <x-slot name="url">
                      <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'bloc_milieu']) }}">
                    </x-slot>
                    @endisset

                    @include('partials.place.sections.bloc-milieu')
                  </x-edit-section>

                <x-edit-section :edit="isset($edit)" section="bloc_droite" :sections="$sections" class="column">
                  @isset($edit)
                  <x-slot name="url">
                    <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'bloc_droite']) }}">
                  </x-slot>
                  @endisset

                  @include('partials.place.sections.bloc-droite')
                </x-edit-section>
              </div>
            </section>
          </div>
          <section>
            <div class="section" style="padding:0;">
              <div class="columns has-text-centered ">
                <x-edit-section :edit="isset($edit)" section="public" :sections="$sections" class="column">
                  @isset($edit)
                  <x-slot name="url">
                    <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'public']) }}">
                  </x-slot>
                  @endisset

                  @include('partials.place.sections.public')
                </x-edit-section>

                <x-edit-section :edit="isset($edit)" section="accessibilite" :sections="$sections" class="column">
                  @isset($edit)
                  <x-slot name="url">
                    <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'accessibilite']) }}">
                  </x-slot>
                  @endisset

                  @include('partials.place.sections.accessibilite')
                </x-edit-section>

                <x-edit-section :edit="isset($edit)" section="transport" :sections="$sections" class="column">
                  @isset($edit)
                  <x-slot name="url">
                    <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'transport']) }}">
                  </x-slot>
                  @endisset

                  @include('partials.place.sections.transport')
                </x-edit-section>
              </div>
            </div>
          </section>

          <section class="section" id="valeurs">
          <x-edit-section :edit="isset($edit)" section="valeurs" :sections="$sections">
            @isset($edit)
            <x-slot name="url">
              <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'valeurs']) }}">
            </x-slot>
            @endisset

            @include('partials.place.sections.values')
          </x-edit-section>
          </section>

            <section class="section" id="finances" >
              <div class="columns">
                @php $class="" @endphp
                @if (!isset($edit) && (!$sections->has('composition') || !$sections->get('composition')))
                  @php $class="is-6 is-offset-3" @endphp
                @endif
                <x-edit-section :edit="isset($edit)" section="moyens" :sections="$sections" class="column {{ $class }}">
                  @isset($edit)
                  <x-slot name="url">
                    <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'moyens']) }}">
                  </x-slot>
                  @endisset

                  @include('partials.place.sections.moyens')
                </x-edit-section>

                @php $class="" @endphp
                @if (!isset($edit) && (!$sections->has('moyens') || !$sections->get('moyens')))
                  @php $class="is-6 is-offset-3" @endphp
                @endif
                <x-edit-section :edit="isset($edit)" section="composition" :sections="$sections" class="column {{ $class }}">
                  @isset($edit)
                  <x-slot name="url">
                    <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'composition']) }}">
                  </x-slot>
                  @endisset

                  @include('partials.place.sections.composition')
                </x-edit-section>
              </div>
            </section>

            <section class="section" id="impact-social">
              @include('partials.place.sections.impact-social')
            </section>

      <section class="section anchor" id="lieu_territoire">
        <x-edit-section :edit="isset($edit)" section="lieu_territoire" :sections="$sections">
          @isset($edit)
          <x-slot name="url">
            <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'lieu_territoire']) }}">
          </x-slot>
          @endisset

          <h2 class="ribbon-banner title is-5 has-text-centered">Le lieu dans son territoire</h2>
          <div class="section">
            <div class="columns">
              <div class="column">
                <label class="is-pulled-right pt-4">Choississez un découpage géographique: </label>
              </div>
              <div class="column is-pulled-left">
                <div class="mb-5 control has-icons-left">
                  <div class="select">
                    <select id="selectGeo">
                      <option value="iris" selected>Proximité immédiate</option>
                      <option value="commune">Commune</option>
                      <option value="departement">Département</option>
                      <option value="region">Région</option>
                    </select>
                  </div>
                  <span class="icon is-large is-left">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
              </div>
            </div>

            <div class="columns card is-rounded">
              <div class="column " style="width: 100%; height: 35em;">
                <div id="map-insee"></div>
              </div>
              <div class="column is-7">
                <div class="columns">
                  <div class="column">
                      <div id="actifsChart"></div>
                      <div id="cateChart"></div>
                      <div id="immoChart"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </x-edit-section>
      </section>
    </div>
</div>


@endsection
