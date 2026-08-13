<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Une Factory génère de fausses données réalistes pour les tests,
 * sans avoir à les taper à la main à chaque fois.
 */
class EtudiantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom'       => fake()->lastName(),
            'prenom'    => fake()->firstName(),
            'email'     => fake()->unique()->safeEmail(),
            'matricule' => 'ETU' . fake()->unique()->numberBetween(1000, 9999),
        ];
    }
}