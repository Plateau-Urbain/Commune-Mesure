@extends('layout')

@section('content')
  @unless($result)
    <section class="hero is-halfheight">
      <div class="hero-body">
        <div class="column is-full"> {{-- utile pour le subtitle --}}
          <p class="title">Saisir la recherche</p>
          <div class="field">
            <p class="subtitle control is-expanded">
              <input type="text" class="input" placeholder="Rechercher un lieu">
            </p>
          </div>
        </div>
      </div>
    </section>
  @endif
@endsection
