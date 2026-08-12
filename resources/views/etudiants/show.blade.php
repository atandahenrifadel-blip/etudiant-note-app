@extends('layouts.app')

@section('content')
    <a href="{{ route('etudiants.index') }}">&larr; Retour à la liste</a>

    <h1>{{ $etudiant->prenom }} {{ $etudiant->nom }}</h1>
    <p>Matricule : {{ $etudiant->matricule }} — Email : {{ $etudiant->email }}</p>
    <p><strong>Moyenne générale : {{ $etudiant->moyenne() }}/20</strong></p>

    <h2>Notes</h2>
    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Type</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- $etudiant->notes vient de la relation hasMany() définie dans le modèle --}}
            @foreach ($etudiant->notes as $note)
                <tr>
                    <td>{{ $note->matiere }}</td>
                    <td>{{ $note->type_evaluation }}</td>
                    <td>{{ $note->valeur }}/20</td>
                    <td>
                        <form class="inline" method="POST"
                              action="{{ route('etudiants.notes.destroy', [$etudiant, $note]) }}"
                              onsubmit="return confirm('Supprimer cette note ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Ajouter une note</h3>
    <form method="POST" action="{{ route('etudiants.notes.store', $etudiant) }}">
        @csrf
        <input type="text" name="matiere" placeholder="Matière" value="{{ old('matiere') }}">
        @error('matiere') <small style="color:red">{{ $message }}</small> @enderror

        <select name="type_evaluation">
            <option value="Devoir">Devoir</option>
            <option value="Examen">Examen</option>
            <option value="TP">TP</option>
        </select>

        {{-- step="0.5" et min/max donnent une aide côté navigateur, --}}
        {{-- mais la vraie vérification (sécurité) se fait côté serveur dans le contrôleur --}}
        <input type="number" name="valeur" step="0.5" min="0" max="20" placeholder="Note /20"
               value="{{ old('valeur') }}">
        @error('valeur') <small style="color:red">{{ $message }}</small> @enderror

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
@endsection
