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
          <div class="columns">
            <div class="column">
              <label class="is-pulled-right pt-4">Trier par </label>
            </div>
              <div class="column is-pulled-left">
                <div class="mb-5 control has-icons-left">
                  <div class="select">
                    <select id="selectSort" onchange="sortPlaces(this)">
                      <option class="sort" value="" @if($selected == "default_az")
                                                    selected
                                                @endif>Ordre A-Z</option>
                      @foreach ($places[0]->data->compare as $key_name => $programmations )
                      <optgroup label="{{ $key_name }}">
                        @foreach ($programmations as $key_prog_name => $programmation )
                        <option class="sort" value="{{ $key_name }}-{{ $key_prog_name }}"
                        @if($selected == $key_prog_name):
                          selected @endif
                        >
                          {{ $programmation->title }}
                        </option>
                        @endforeach
                      </optgroup>
                      @endforeach
                    </select>
                  </div>
                  <span class="icon is-large is-left">
                    <i class="fas fa-sort-alpha-down"></i>
                  </span>

                </div>
              </div>
            </div>
            @foreach ($places as $place)
                <div class="box content">
                    <div class="columns is-bordered places-block">
                        <div class="column">
                            <p class="title"><a href="{{ route('place.show',['slug' => $place->title ])  }}">{{ $place->name  }}</a></p>
                            <p>{{ $place->description }}</p>
                            <div>
                                <ul class="">
                                  <p><strong>{{ $place->address->city  }}</strong></p>
                                </ul>
                            </div>
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
