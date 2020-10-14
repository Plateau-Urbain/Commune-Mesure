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
                        <div class="column is-clickable" style="position:relative; height:250px; overflow: hidden;">
                            <p class="title mb-4"><a href="{{ route('place.show',['slug' => $place->title ])  }}">{{ $place->name  }}</a><br />
                            <span class="title_places-city is-size-4" style="font-weight: normal">{{ $place->address->city  }} ({{ substr($place->address->postalcode, 0, 2) }})</span></p>
                            <p style="text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3;-webkit-box-orient: vertical;">{{ $place->description }}</p>
                            <ul class="tags_container">
                            @foreach($place->tags as $tag)
                            <li class="tags">{{$tag}}</li>
                            @endforeach
                            </ul>
                            <a href="{{ route('place.show',['slug' => $place->title ])  }}" class="btn-voir-lieu button is-default">Voir ce lieu</a>
                        </div>
                        <div class="column is-one-third has-text-centered" style="overflow: hidden;">
                            <div id="carousel-{{ $place->title }}" style="height: 230px; overflow: hidden;" class="carousel">
                            @if( $place->photos[0] )
                              <img class="img-places" style="height: 230px;" src='{{ url("/") }}/images/lieux/{{ $place->photos[0] }}'>
                            @endif
                              <div class="map-place" style="height: 230px;" id="map_{{ $place->title }}"></div>
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
  @include('components.places.map-js')
  @include('components.places.sortPlaces-js')
@endsection
