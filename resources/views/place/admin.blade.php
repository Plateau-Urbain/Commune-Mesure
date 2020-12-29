@extends('layout')

@section('title')
  <h1 class="title header-title">
    {{ $place->name }}
  </h1>
  <h2 class="subtitle">
      {{ $place->address->city }}
  </h2>
@endsection

@section('content')
    <div class="has-background-warning">
        <div class="container">
            <p class="has-text-centered has-text-weight-bold py-2">Vous êtes en mode édition</p>
        </div>
    </div>

    <div class="container">
      <section class="section">
        <h3 class="title is-3 has-text-centered">Présentation du lieu</h3>

        <div class="columns">
          <div class="column">
            <label><input type=checkbox checked> Idée fondatrice</label>
          </div>
          <div class="column">
            <label><input type=checkbox checked> Structures occ.</label>
            <label><input type=checkbox checked> Gouvernance</label>
            <label><input type=checkbox checked> Surface</label>
            <label><input type=checkbox checked> ETP</label>
          </div>
          <div class="column">
            <label><input type=checkbox checked> Acteurs Pub</label>
            <label><input type=checkbox checked> Acteurs Pri</label>
            <label><input type=checkbox checked> Partenariat</label>
          </div>
        </div>
      </section>
      <section class="section">
        <h3 class="title is-3 has-text-centered">Les valeurs</h3>
      </section>
      <div class="columns">
        <div class="column">
          <section class="section">
            <h3 class="title is-3 has-text-centered">Les moyens</h3>
          </section>
        </div>
        <div class="column">
          <section class="section">
            <h3 class="title is-3 has-text-centered">La composition</h3>
          </section>
        </div>
      </div>
      <section class="section">
        <h3 class="title is-3 has-text-centered">L'impact social</h3>
      </section>
      <section class="section">
        <h3 class="title is-3 has-text-centered">Le territoire</h3>
      </section>
    </div>
@endsection
