<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;

/**
 * Un Contrôleur reçoit les requêtes HTTP (venant du navigateur ou d'une API)
 * et décide quoi faire : lire/écrire en base, puis renvoyer une réponse
 * (une vue HTML ou du JSON).
 *
 * Ici on fait du CRUD classique : Create, Read, Update, Delete.
 */
class EtudiantController extends Controller
{
    /**
     * READ (liste) : afficher tous les étudiants.
     * Route : GET /etudiants
     */
    public function index()
    {
        // with('notes') charge aussi les notes liées en une seule requête
        // (évite le problème "N+1 requêtes", bonne pratique de performance)
        $etudiants = Etudiant::with('notes')->latest()->paginate(10);

        return view('etudiants.index', compact('etudiants'));
    }

    /**
     * Affiche le formulaire de création.
     * Route : GET /etudiants/create
     */
    public function create()
    {
        return view('etudiants.create');
    }

    /**
     * CREATE : enregistre un nouvel étudiant.
     * Route : POST /etudiants
     */
    public function store(Request $request)
    {
        // -----------------------------------------------------------------
        // VALIDATION DES DONNÉES : c'est ici que commence la sécurité (DevSecOps).
        // On n'accepte JAMAIS de faire confiance aveuglément à ce qui vient
        // du formulaire. Laravel rejette automatiquement la requête et
        // réaffiche le formulaire avec les erreurs si une règle échoue.
        // -----------------------------------------------------------------
        $validated = $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            // "email" vérifie le format, "unique" empêche les doublons en base
            'email'     => 'required|email|unique:etudiants,email',
            'matricule' => 'required|string|max:50|unique:etudiants,matricule',
        ]);

        Etudiant::create($validated);

        // redirect()->with() envoie un message flash affiché une seule fois
        return redirect()->route('etudiants.index')
                          ->with('success', 'Étudiant créé avec succès.');
    }

    /**
     * READ (détail) : affiche un étudiant et toutes ses notes.
     * Route : GET /etudiants/{etudiant}
     *
     * Grâce au "Route Model Binding" de Laravel, {etudiant} est
     * automatiquement transformé en instance Etudiant (ou erreur 404
     * si l'id n'existe pas) — pas besoin de faire Etudiant::find() nous-mêmes.
     */
    public function show(Etudiant $etudiant)
    {
        $etudiant->load('notes'); // charge la relation notes
        return view('etudiants.show', compact('etudiant'));
    }

    /**
     * Affiche le formulaire d'édition.
     * Route : GET /etudiants/{etudiant}/edit
     */
    public function edit(Etudiant $etudiant)
    {
        return view('etudiants.edit', compact('etudiant'));
    }

    /**
     * UPDATE : met à jour un étudiant existant.
     * Route : PUT/PATCH /etudiants/{etudiant}
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        $validated = $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            // "unique" ignore la ligne actuelle grâce à ignore($etudiant->id)
            'email'     => 'required|email|unique:etudiants,email,' . $etudiant->id,
            'matricule' => 'required|string|max:50|unique:etudiants,matricule,' . $etudiant->id,
        ]);

        $etudiant->update($validated);

        return redirect()->route('etudiants.index')
                          ->with('success', 'Étudiant mis à jour.');
    }

    /**
     * DELETE : supprime un étudiant (et ses notes, grâce à onDelete('cascade')
     * défini dans la migration).
     * Route : DELETE /etudiants/{etudiant}
     */
    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();

        return redirect()->route('etudiants.index')
                          ->with('success', 'Étudiant supprimé.');
    }
}
