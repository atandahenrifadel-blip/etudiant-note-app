<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'matiere',
        'valeur',
        'type_evaluation',
    ];

    /**
     * On force le type de la colonne "valeur" en float côté PHP,
     * pour être sûr de manipuler un nombre et pas une chaîne de caractères.
     */
    protected $casts = [
        'valeur' => 'float',
    ];

    /**
     * ASSOCIATION inverse : une Note appartient à un seul Étudiant.
     * belongsTo() dit à Laravel : "va chercher dans la table etudiants
     * la ligne dont l'id correspond à etudiant_id de cette note".
     */
    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }
}
