{{-- @extends dit "cette page utilise le layout app.blade.php" --}}
@extends('layouts.app')

@section('content')
    <h1>Liste des étudiants</h1>

    <a href="{{ route('etudiants.create') }}" class="btn btn-primary">+ Nouvel étudiant</a>

    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Moyenne</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach parcourt la collection $etudiants envoyée par le contrôleur --}}
            @foreach ($etudiants as $etudiant)
                <tr>
                    <td>{{ $etudiant->matricule }}</td>
                    <td>{{ $etudiant->nom }}</td>
                    <td>{{ $etudiant->prenom }}</td>
                    {{-- {{ }} échappe automatiquement le HTML : protection contre les failles XSS --}}
                    <td>{{ $etudiant->email }}</td>
                    <td>{{ $etudiant->moyenne() }}/20</td>
                    <td>
                        <a href="{{ route('etudiants.show', $etudiant) }}">Voir</a> |
                        <a href="{{ route('etudiants.edit', $etudiant) }}">Modifier</a> |
                        <form class="inline" method="POST" action="{{ route('etudiants.destroy', $etudiant) }}"
                              onsubmit="return confirm('Confirmer la suppression ?');">
                            {{-- @csrf : jeton anti-falsification de requête (sécurité Laravel) --}}
                            @csrf
                            {{-- @method('DELETE') simule une requête DELETE via un formulaire HTML --}}
                            @method('DELETE')
                            <button type="submit" class="btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination automatique fournie par paginate(10) dans le contrôleur --}}
    {{ $etudiants->links() }}
@endsection
