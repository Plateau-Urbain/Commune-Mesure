@extends('layout')

@section('head_css')
  @parent
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">

@endsection

@section('content')
    <div class="container">
        <div class="hero is-large is-light">
            <section class="section">
                <h1 class="title is-1 has-text-centered">Les lieux</h1>
            </section>
        </div>
        <div class="section">
            @foreach ($places as $place)
                <div class="box content">
                    <div class="columns is-bordered places-block">
                        <div class="column" style="position:relative;min-height:250px;">
                            <p class="title"><a href="{{ route('place.show',['slug' => $place->title ])  }}">{{ $place->name  }}</a><span class="title_places-city"> - <strong>{{ $place->address->city  }}</strong></span></p>
                            <p>{{ $place->description }}</p>
                            <ul class="tags_container">
                            @foreach($place->tags as $tag)
                            <li class="tags">{{$tag}}</li>
                            @endforeach
                            </ul>
                        </div>

                        <div class="column is-one-third has-text-centered" style="overflow-x: hidden">
                            <div id="carousel-{{ $place->title }}" class="carousel">
                              <img class="img-places" src='{{ url("/") }}/images/{{ $place->photos[0] }}'>
                              <div class="map-place" id="map_{{ $place->title }}"></div>
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
