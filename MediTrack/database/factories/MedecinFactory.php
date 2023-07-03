<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medecin>
 */
class MedecinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'nom' =>'Yechhab',
          'prenom' =>'Fatimaezzahra',
          'CIN' =>'AA123456',
            'email' =>'fatimayechhab@gmail.com',
            'password' =>bcrypt('faty'),
            'sexe' =>'Femme',
            'date_debut' =>'2021-05-23',
            'specialite' =>'Dentiste',
            
        ];
    }
}
