@extends('layouts.app')

@section('content')
    <h1>Modifier l'étudiant</h1>

    <form method="POST" action="{{ route('etudiants.update', $etudiant) }}">
        @csrf
        @method('PUT') {{-- On simule une requête PUT (mise à jour) --}}

        <label>Nom</label><br>
        <input type="text" name="nom" value="{{ old('nom', $etudiant->nom) }}"><br>
        @error('nom') <small style="color:red">{{ $message }}</small> @enderror
        <br><br>

        <label>Prénom</label><br>
        <input type="text" name="prenom" value="{{ old('prenom', $etudiant->prenom) }}"><br>
        @error('prenom') <small style="color:red">{{ $message }}</small> @enderror
        <br><br>

        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email', $etudiant->email) }}"><br>
        @error('email') <small style="color:red">{{ $message }}</small> @enderror
        <br><br>

        <label>Matricule</label><br>
        <input type="text" name="matricule" value="{{ old('matricule', $etudiant->matricule) }}"><br>
        @error('matricule') <small style="color:red">{{ $message }}</small> @enderror
        <br><br>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('etudiants.index') }}">Annuler</a>
    </form>
@endsection
