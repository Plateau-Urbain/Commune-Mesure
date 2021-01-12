@extends('layout')

@section('content')
    <div class="container">
        <div class="hero is-large">
            <section class="section">
                <h1 class="title is-1 has-text-centered">Administration de lieux</h1>
            </section>
        </div>
        <div class="section">
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Page d'administration</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($list as $place)
                    <tr>
                        <td>
                            <p class="has-text-weight-bold"><a href="{{ route('place.show', ['slug' => $place->url]) }}">{{ $place->name }}</a></p>
                            <p class="has-text-grey-dark is-size-7">{{ $place->city }} ({{ substr($place->postalcode, 0, 2) }})</p>
                        </td>
                        <td>
                            <a target="_blank" href="{{ route('place.admin', ['slug' => $place->url, 'auth' => 'placeholder']) }}">Espace d'admin</a>
                        </td>
                        <td>
                            <button class="button is-success" disabled>
                                <span class="icon is-small">
                                    <i class="fas fa-download"></i>
                                </span>
                                <span>Télécharger le csv</span>
                            </button>
                            <button class="button is-warning" disabled>
                                <span class="icon is-small">
                                    <i class="fas fa-redo"></i>
                                </span>
                                <span>Changer la hash admin</span>
                            </button>
                            <button class="button is-danger is-outlined" disabled>
                                <span>Delete</span>
                                <span class="icon is-small">
                                    <i class="fas fa-times"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>

@endsection
