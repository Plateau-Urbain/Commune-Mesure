@extends('layout')

@section('content')
    <div id="page-listing-lieux" class="container">
        <div class="hero is-large is-light">
            <section class="section">
                <h1 class="title is-1 has-text-centered">L’ensemble des lieux recensés</h1>
            </section>
        </div>
        <div class="section">
          <div class="columns is-multiline">
            @foreach ($places as $place)
              <div class="column is-3">
                <div class="card" style="height: 700px">
                  <div class="card-image">
                    <div id="carousel-{{ $place->getSlug() }}" class="carousel carousel-container">
                      @if (count($place->getPhotos()) > 0)
                        @foreach ($place->getPhotos() as $photo)
                          <figure class="image is-contained">
                            <img src="{{ url('/') }}/images/lieux/{{ $photo }}">
                          </figure>
                        @endforeach
                      @endif

                      <div class="map-place" id="map_{{ $place->getSlug() }}"></div>
                    </div>
                  </div>

                  <div class="card-content is-relative">
                    <a class="title has-text-primary"
                      @if ($place->isPublish()) href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" @else style="cursor: not-allowed" @endif
                    >{{ $place->get('name') }}</a>
                    <p class="is-size-4 has-text-weight-normal">{{ $place->get('address->city') }} ({{ substr($place->get('address->postalcode'), 0, 2) }})</p>

                    <div class="content mt-4">
                      @if ($place->isPublish())
                        <p style="text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3;-webkit-box-orient: vertical;">{{ $place->get('blocs->presentation->donnees->idee_fondatrice') }}</p>
                      @endif
                    </div>
                    <div style="position: absolute; bottom: 0;">
                      @if ($place->isPublish())
                        <a href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button is-fullwidth">Voir son datapanorama</a>
                        <a href="{{ route('impacts.show',['slug' => $place->getSlug() ]) }}" class="button is-fullwidth mt-2">Voir ses effets sociaux</a>
                      @else
                        <p class="is-italic">Plus d'infos à venir&hellip; Dès la publication du datapanorama par les responsables du tiers lieux.</p>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
    </div>

@endsection
@section('script_js')
  @parent
  @include('partials.places.map-js')
  @include('partials.places.sortPlaces-js')
@endsection
