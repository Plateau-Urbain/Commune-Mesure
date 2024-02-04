@extends('layout')

@section('title')
  {{-- vide --}}
@endsection

@section('content')
    <div id="page-listing-lieux" class="container">
        <div class="hero is-large mt-4">
            <section class="section pb-0">
                <h1 style="color: #413f4b;" class="title is-3 has-text-centered is-uppercase">L’ensemble des lieux recensés</h1>
            </section>
        </div>
        <div class="section">
          <p class="block has-text-grey mb-3">Trié par : les plus récents</p>
          <div class="columns is-multiline">
            @foreach ($places as $place)
              <div class="column is-3">
                <div class="card" style="height: 100%;">
                  <div class="card-image">
                    <div id="carousel-{{ $place->getSlug() }}" class="carousel-listing carousel-container" style="height: 250px;">
                      @if (count($place->getPhotos()) > 0)
                        @foreach ($place->getPhotos() as $photo)
                          <figure class="image contained">
                            <img src="{{ url('/') }}/images/lieux/thumbnail/{{ $photo }}">
                          </figure>
                        @endforeach
                      @endif

                      <div style="z-index: -1;" class="map-place" id="map_{{ $place->getSlug() }}"></div>
                    </div>
                  </div>

                  <div class="card-content p-4" style="display: flex; justify-content: space-between; flex-direction: column; height: 330px;">
                    <div style="justify-content: normal;">
                      <p title="{{ $place->get('address->city') }}" style="white-space: nowrap; text-overflow: '... ({{ substr($place->get('address->postalcode'), 0, 2) }})'; overflow: hidden;" class="is-size-5 has-text-weight-normal">{{ str_replace('Arrondissement', '', $place->get('address->city')) }}</span> ({{ substr($place->get('address->postalcode'), 0, 2) }})</p>
                      <a title="{{ $place->get('name') }}" style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-size: 1.4rem !important;" class="title has-text-primary is-uppercase is-size-5 mb-0"
                        @if ($place->isPublish()) href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" @else style="cursor: not-allowed" @endif
                      >{{ $place->get('name') }}</a>

                      <div class="content mt-1">
                        @if ($place->isPublish())
                          <p style="text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3;-webkit-box-orient: vertical;">{!! str_replace( "\\n", '<br />', $place->get('blocs->presentation->donnees->idee_fondatrice')) !!}</p>
                        @else
                          <p class="has-text-grey-light">Plus d'infos à venir&hellip; Dès la publication du datapanorama par les responsables du tiers lieux.</p>
                        @endif
                      </div>
                    </div>
                    <div style="justify-content: flex-end">
                    @if ($place->isPublish())
                      @if (!empty($place->get('blocs->impact_social')))
                        <a href="{{ route('impacts.show',['slug' => $place->getSlug() ]) }}" class="button is-fullwidth">Voir ses effets sociaux</a>
                      @else
                        <button type="button" disabled href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button is-fullwidth mt-2 is-transparent">Voir ses effets sociaux</button>
                      @endif
                      <a href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button is-fullwidth mt-2">Voir son datapanorama</a>
                      @if (true === $place['hasEnvironmentalPart'])
                        <a href="{{ route('environment.show',['slug' => $place->getSlug() ]) }}" class="button is-fullwidth mt-2">Voir sa partie environnementale</a>
                      @else
                        <button type="button" disabled href="{{ route('environment.show', ['slug' => $place->getSlug()]) }}" class="button is-fullwidth mt-2 is-transparent">Voir sa partie environnementale</button>
                      @endif
                    @else
                      <button type="button" disabled href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button is-fullwidth mt-2 is-transparent">Voir ses effets sociaux</button>
                      <button type="button" disabled href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button is-fullwidth mt-2 is-transparent">Voir son datapanorama</button>
                    @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          {!! $paginatedPlaces->links() !!}
        </div>
    </div>

@endsection
@section('script_js')
  @parent
  @include('partials.places.map-js')
@endsection
