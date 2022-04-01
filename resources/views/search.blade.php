@extends('layout')

@section('content')
  @unless($search)
    <section class="hero is-halfheight">
      <div class="hero-body">
        <div class="column is-full"> {{-- utile pour le subtitle --}}
          <p class="title">Saisir la recherche</p>
          <div class="field">
            <p class="subtitle control is-expanded">
              <form method="GET" action={{ route('search') }}>
                <input type="text" name="q" class="input" placeholder="Rechercher un lieu">
              </form>
            </p>
          </div>
        </div>
      </div>
    </section>
  @else
    <div class="container">
      <section class="section">
        <h3 class="title is-2">Résultats de la recherche pour « {{ $search }} »</h3>
        @foreach ($results as $result)
          <article class="media">
            <figure class="media-left">
              <p class="image is-128x128">
                <a href="{{ $result->url }}"><img src="https://bulma.io/images/placeholders/128x128.png"></a>
              </p>
            </figure>
            <div class="media-content">
              <div class="content">
                <p>
                  <strong><a href="{{ $result->url }}" title="Accéder au lieu">{{ $result->title }}</a></strong> <small class="ml-2 has-text-grey">{{ '@'.$result->slug }}</small>
                  <br>
                  {{ $result->description }}
                </p>
              </div>
              <nav class="level is-mobile is-align-content-baseline">
                <a href="{{ $result->url }}" title="Accéder au lieu" class="button is-small is-primary">Accéder au lieu</a>
              </nav>
            </div>
          </article>
        @endforeach
      </section>
    </div>
  @endif
@endsection
