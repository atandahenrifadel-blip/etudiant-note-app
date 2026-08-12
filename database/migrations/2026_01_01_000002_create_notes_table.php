<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Cette migration crée la table "notes".
 * C'est ici que se matérialise l'ASSOCIATION entre Étudiant et Note :
 * une Note "appartient à" un Étudiant (relation 1-N : un étudiant a plusieurs notes).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            // foreignId() crée une colonne "etudiant_id" (clé étrangère).
            // constrained() dit à Laravel : "relie cette colonne à la table etudiants".
            // onDelete('cascade') : si on supprime un étudiant, ses notes sont supprimées aussi
            // (intégrité référentielle gérée au niveau base de données).
            $table->foreignId('etudiant_id')
                  ->constrained('etudiants')
                  ->onDelete('cascade');

            $table->string('matiere');           // Nom de la matière évaluée (ex: Mathématiques)
            $table->decimal('valeur', 4, 2);     // La note elle-même, ex: 15.50 (4 chiffres, 2 après la virgule)
            $table->string('type_evaluation')->default('Examen'); // Type: Devoir, Examen, TP...
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
