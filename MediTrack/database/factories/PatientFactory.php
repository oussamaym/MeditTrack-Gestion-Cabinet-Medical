<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => 'Yechhab',
        'prenom',=> 'Fatimaezzahra',
        'email'=> 'fatimayechhab@gmail.com',
        'CIN'=> 'A',
        'password',
        'sexe',
        'date_naissance',
        'adresse',
        'telephone',
        'photo',
        ];
    }
}
