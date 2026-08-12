<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Un test "Feature" simule une vraie requête HTTP (comme un utilisateur
 * qui clique dans le navigateur) et vérifie le résultat.
 *
 * C'est CE fichier que le pipeline CI va exécuter automatiquement
 * à chaque push : si un test échoue, le pipeline échoue et bloque
 * le déploiement. C'est le principe central du DevOps : détecter
 * les erreurs tôt, automatiquement, avant qu'elles n'atteignent la prod.
 */
class EtudiantTest extends TestCase
{
    // RefreshDatabase : recrée une base de données propre avant chaque test
    use RefreshDatabase;

    /** @test */
    public function on_peut_afficher_la_liste_des_etudiants(): void
    {
        // Arrange : on prépare des données de test
        Etudiant::factory()->count(3)->create();

        // Act : on simule une visite de la page
        $response = $this->get(route('etudiants.index'));

        // Assert : on vérifie le résultat attendu
        $response->assertStatus(200);
    }

    /** @test */
    public function on_peut_creer_un_etudiant_valide(): void
    {
        $donnees = [
            'nom'       => 'Kouassi',
            'prenom'    => 'Henry',
            'email'     => 'henry.kouassi@example.com',
            'matricule' => 'ETU2026-001',
        ];

        $response = $this->post(route('etudiants.store'), $donnees);

        // On vérifie que l'utilisateur est bien redirigé après création
        $response->assertRedirect(route('etudiants.index'));

        // On vérifie que la donnée existe bien en base
        $this->assertDatabaseHas('etudiants', ['email' => 'henry.kouassi@example.com']);
    }

    /** @test */
    public function la_creation_echoue_si_email_invalide(): void
    {
        // Test de sécurité/robustesse : un email mal formé doit être rejeté
        $response = $this->post(route('etudiants.store'), [
            'nom'       => 'Kouassi',
            'prenom'    => 'Henry',
            'email'     => 'pas-un-email',
            'matricule' => 'ETU2026-002',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('etudiants', ['matricule' => 'ETU2026-002']);
    }
}
