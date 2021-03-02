@extends('layout')

@section('content')
    <div class="container">
        <div class="hero is-large is-light">
            <section class="section">
                <h1 class="title is-1 has-text-centered">Les lieux</h1>
            </section>
        </div>
        <div class="section">
            @foreach ($places as $place)
                <div class="box box-lieu content">
                    <div class="columns is-bordered places-block">
                        <div class="column is-clickable" style="position:relative; height:250px;">
                            <p class="title mb-4"><a href="{{ route('place.show',['slug' => $place->get('url') ]) }}">{{ $place->get('name') }}</a><br />
                            <span class="title_places-city is-size-4" style="font-weight: normal">{{ $place->get('city') }} ({{ substr($place->get('postalcode'), 0, 2) }})</span></p>
                            <p style="text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3;-webkit-box-orient: vertical;">{{ (json_decode($place->get('description')))->value }}</p>
                            <ul class="tags_container">
                            @foreach(json_decode($place->get('tags')) as $tag)
                              <li class="tags">{{$tag}}</li>
                            @endforeach
                            </ul>
                            <a href="{{ route('place.show',['slug' => $place->get('url') ]) }}" class="btn-voir-lieu button is-default">Voir ce lieu</a>
                        </div>
                        <div class="column is-one-third has-text-centered">
                            <div id="carousel-{{ $place->get('url') }}" class="carousel carousel-container">
                            @if( count(json_decode($place->get('photos'))) > 0)
                              <img class="img-places" height="230px" src='{{ url("/") }}/images/lieux/{{ json_decode($place->get('photos'))[0] }}'>
                            @endif
                              <div class="map-place" id="map_{{ $place->get('url') }}"></div>
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
