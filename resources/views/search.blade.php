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
  @endif
@endsection
