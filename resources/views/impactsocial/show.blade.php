@extends('layout')

@section('title')
  Les impacts de {{ $place->place }}.
@endsection

@section('content')
  <div class="container has-text-centered">Contenu de la page : {{ $place->data->impact->solidarite }}</div>
@endsection
