@extends('layouts.app')

@section('content')
    <h1>Nouvel étudiant</h1>

    <form method="POST" action="{{ route('etudiants.store') }}">
        @csrf {{-- Obligatoire sur CHAQUE formulaire POST/PUT/DELETE pour la sécurité --}}

        <label>Nom</label><br>
        {{-- old('nom') redonne la valeur tapée précédemment si la validation a échoué --}}
        <input type="text" name="nom" value="{{ old('nom') }}"><br>
        {{-- @error affiche le message de validation Laravel s'il y en a un pour ce champ --}}
        @error('nom') <small style="color:red">{{ $message }}</small> @enderror
        <br><br>

        <label>Prénom</label><br>
        <input type="text" name="prenom" value="{{ old('prenom') }}"><br>
        @error('prenom') <small style="color:red">{{ $message }}</small> @enderror
        <br><br>

        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}"><br>
        @error('email') <small style="color:red">{{ $message }}</small> @enderror
        <br><br>

        <label>Matricule</label><br>
        <input type="text" name="matricule" value="{{ old('matricule') }}"><br>
        @error('matricule') <small style="color:red">{{ $message }}</small> @enderror
        <br><br>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('etudiants.index') }}">Annuler</a>
    </form>
@endsection
