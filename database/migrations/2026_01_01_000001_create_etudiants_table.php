<?php

// On importe les classes nécessaires fournies par Laravel
use Illuminate\Database\Migrations\Migration; // Classe de base pour toute migration
use Illuminate\Database\Schema\Blueprint;       // Permet de "dessiner" la structure d'une table
use Illuminate\Support\Facades\Schema;          // Facade pour exécuter des opérations sur le schéma (create, drop...)

/**
 * Une "migration" en Laravel = un fichier qui décrit une modification
 * de la base de données (créer/modifier/supprimer une table).
 * Avantage DevOps : la base de données est versionnée comme le code,
 * donc on peut la recréer à l'identique sur n'importe quelle machine
 * (poste du dev, serveur de test, conteneur Docker, etc.).
 */
return new class extends Migration
{
    /**
     * Cette méthode s'exécute quand on lance : php artisan migrate
     * Elle crée la table "etudiants".
     */
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée (id)
            $table->string('nom');            // Nom de l'étudiant (texte court)
            $table->string('prenom');         // Prénom de l'étudiant
            $table->string('email')->unique(); // Email, doit être unique dans la table
            $table->string('matricule')->unique(); // Numéro d'étudiant unique
            $table->timestamps(); // Ajoute automatiquement created_at et updated_at
        });
    }

    /**
     * Cette méthode s'exécute quand on annule la migration : php artisan migrate:rollback
     * Elle supprime la table si on revient en arrière.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
