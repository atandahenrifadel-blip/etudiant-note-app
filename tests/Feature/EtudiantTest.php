<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EtudiantTest extends TestCase
{
    use RefreshDatabase;

    public function test_on_peut_afficher_la_liste_des_etudiants(): void
    {
        Etudiant::factory()->count(3)->create();

        $response = $this->get(route('etudiants.index'));

        $response->assertStatus(200);
    }

    public function test_on_peut_creer_un_etudiant_valide(): void
    {
        $donnees = [
            'nom'       => 'Kouassi',
            'prenom'    => 'Henry',
            'email'     => 'henry.kouassi@example.com',
            'matricule' => 'ETU2026-001',
        ];

        $response = $this->post(route('etudiants.store'), $donnees);

        $response->assertRedirect(route('etudiants.index'));

        $this->assertDatabaseHas('etudiants', ['email' => 'henry.kouassi@example.com']);
    }

    public function test_la_creation_echoue_si_email_invalide(): void
    {
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