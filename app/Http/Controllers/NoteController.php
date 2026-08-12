<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Note;
use Illuminate\Http\Request;

/**
 * Ce contrôleur gère les notes d'UN étudiant en particulier.
 * On dit que c'est une ressource "imbriquée" (nested resource) :
 * les routes ressemblent à /etudiants/{etudiant}/notes
 */
class NoteController extends Controller
{
    /**
     * CREATE : ajoute une note à un étudiant.
     * Route : POST /etudiants/{etudiant}/notes
     */
    public function store(Request $request, Etudiant $etudiant)
    {
        $validated = $request->validate([
            'matiere'          => 'required|string|max:255',
            // "between:0,20" empêche d'enregistrer une note incohérente (ex: 45/20)
            'valeur'           => 'required|numeric|between:0,20',
            'type_evaluation'  => 'required|string|max:100',
        ]);

        // On associe automatiquement la note à l'étudiant courant
        // grâce à la relation notes() définie dans le modèle Etudiant.
        $etudiant->notes()->create($validated);

        return redirect()->route('etudiants.show', $etudiant)
                          ->with('success', 'Note ajoutée.');
    }

    /**
     * UPDATE : modifie une note existante.
     * Route : PUT /etudiants/{etudiant}/notes/{note}
     */
    public function update(Request $request, Etudiant $etudiant, Note $note)
    {
        $validated = $request->validate([
            'matiere'          => 'required|string|max:255',
            'valeur'           => 'required|numeric|between:0,20',
            'type_evaluation'  => 'required|string|max:100',
        ]);

        $note->update($validated);

        return redirect()->route('etudiants.show', $etudiant)
                          ->with('success', 'Note mise à jour.');
    }

    /**
     * DELETE : supprime une note.
     * Route : DELETE /etudiants/{etudiant}/notes/{note}
     */
    public function destroy(Etudiant $etudiant, Note $note)
    {
        $note->delete();

        return redirect()->route('etudiants.show', $etudiant)
                          ->with('success', 'Note supprimée.');
    }
}
