<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Un "Model" Eloquent représente une table de la base de données
 * sous forme de classe PHP. Chaque instance de Etudiant = une ligne
 * de la table "etudiants".
 */
class Etudiant extends Model
{
    use HasFactory; // Permet de générer facilement de fausses données pour les tests

    /**
     * $fillable liste les colonnes qu'on autorise à remplir
     * via un formulaire (protection contre l'injection de données non voulues,
     * un premier réflexe "sécurité" -> lien avec DevSecOps).
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'matricule',
    ];

    /**
     * ASSOCIATION : un Étudiant possède plusieurs Notes.
     * hasMany() dit à Laravel : "va chercher dans la table notes
     * toutes les lignes où etudiant_id = l'id de cet étudiant".
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Petite méthode "métier" : calcule la moyenne des notes de l'étudiant.
     * Utile pour l'affichage, et facile à couvrir par un test unitaire.
     */
    public function moyenne(): float
    {
        return round($this->notes()->avg('valeur') ?? 0, 2);
    }
}
