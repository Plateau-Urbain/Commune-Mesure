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

            @foreach ($cities as $city => $places)
            @foreach($places as $place)
                <div class="box content">
                    <div class="columns is-bordered places-block">
                        <div class="column">
                            <p class="title"><a href="{{ route('place.show',['slug' => $place['name']])  }}">{{ $place['title']  }}</a></p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                              Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas
                               non massa sem. Etiam finibus odio quis feugiat facilisis.</p>
                            <div>
                                <ul class="">
                                  <p><strong>{{ $city  }}</strong></p>
                                </ul>
                            </div>
                        </div>
                        <div class="column is-one-third has-text-centered" style="overflow-x: hidden">
                            <div id="carousel-{{ $place['name'] }}" class="carousel">
                              <img class="img-places" src="images/{{ $place['photo'][0] }}">
                              <div class="map-place" id="map_{{ $place['name'] }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                  @endforeach
              @endforeach

        </div>


    </div>

@endsection
@section('script_js')
  @parent
  @include('components.places.map-js')
@endsection
