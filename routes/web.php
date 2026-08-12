<?php

use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

/**
 * Toutes les routes "web" (celles qu'on tape dans le navigateur) sont ici.
 * Route::resource() crée automatiquement les 7 routes CRUD classiques
 * (index, create, store, show, edit, update, destroy) pour un contrôleur.
 */

// Page d'accueil -> redirige vers la liste des étudiants
Route::redirect('/', '/etudiants');

// CRUD complet sur les étudiants : /etudiants, /etudiants/create, etc.
Route::resource('etudiants', EtudiantController::class);

// CRUD imbriqué sur les notes, uniquement store/update/destroy
// (on n'a pas besoin de index/create/show séparés pour les notes,
// elles s'affichent directement dans la page de l'étudiant).
Route::resource('etudiants.notes', NoteController::class)
     ->only(['store', 'update', 'destroy']);
