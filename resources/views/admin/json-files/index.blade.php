@extends('layout')

@section('content')
    <div class="container mt-4 mb-4">
        <div class="box">
            <div class="content has-text-centered">
                <h1 class="title is-5">Fichiers d'import du questionnaire {{ $type }}</h1>
            </div>

            @if ($error)
                <div class="notification is-danger">
                    {{ $error }}
                </div>
            @endif
            <div class="buttons">
                <a href="{{ url('/_admin') }}" class="button">
                    Retour
                </a>
            </div>
            <div class="table-container">
                <table class="table is-fullwidth is-striped is-hoverable">
                    <thead>
                        <tr>
                            <th>Nom du fichier</th>
                            <th>Taille</th>
                            <th>Dernière modification</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jsonFiles as $file)
                            <tr>
                                <td>{{ $file['name'] }}</td>
                                <td>{{ number_format($file['size'] / 1024, 2) }} KB</td>
                                <td>{{ $file['last_modified'] }}</td>
                                <td>
                                    <a href="{{ url('/_admin/json-files/' . $type . '/' . $file['name']) }}" class="has-text-primary">
                                        Éditer
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="has-text-centered has-text-grey">
                                    Aucun fichier JSON trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
