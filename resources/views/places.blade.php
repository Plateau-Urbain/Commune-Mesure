@extends('layout')

@section('content')
    <div class="container">
        <div class="hero is-large is-light">
            <section class="section">
                <h1 class="title is-1 has-text-centered">L’ensemble des lieux recensés</h1>
            </section>
        </div>
        <div class="section">
            @foreach ($places as $place)
                <div class="box box-lieu content">
                    <div class="columns is-bordered places-block">
                        <div class="column" style="position:relative; height:250px;">
                            <p class="title mb-4"><a href="{{ route('place.show',['slug' => $place->getSlug() ]) }}">{{ $place->get('name') }}</a><br />
                            <span class="title_places-city is-size-4" style="font-weight: normal">{{ $place->get('address->city') }} ({{ substr($place->get('address->postalcode'), 0, 2) }})</span></p>
                            <p style="text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3;-webkit-box-orient: vertical;">{{ $place->get('blocs->presentation->donnees->idee_fondatrice') }}</p>
                            <ul class="tags_container">
                            @foreach($place->getData()->tags as $tag)
                              <li class="tags">{{$tag}}</li>
                            @endforeach
                            </ul>
                            <a href="{{ route('place.show',['slug' => $place->getSlug() ]) }}" class="btn-voir-lieu button is-default">Voir ce lieu</a>
                        </div>
                        <div class="column is-one-third has-text-centered">
                            <div id="carousel-{{ $place->getSlug() }}" class="carousel carousel-container">
                            @if( count($place->getPhotos()) > 0)
                              @foreach($place->getPhotos() as $photo)
                              <img class="img-places" height="230px" src='{{ url("/") }}/images/lieux/{{ $photo }}'>
                              @endforeach
                            @endif
                              <div class="map-place" id="map_{{ $place->getSlug() }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
              @endforeach

        </div>


    </div>

@endsection
@section('script_js')
  @parent
  @include('partials.places.map-js')
  @include('partials.places.sortPlaces-js')
@endsection
