@extends('layout')

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
                        <div class="column has-text-centered">
                            <img src="https://fakeimg.pl/350x200/?text={{  $city }}">
                        </div>
                    </div>
                </div>
                  @endforeach
            @endforeach
        </div>
    </div>

@endsection
