<?php

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Seeder;

class ClinicSeeder extends Seeder
{
    public function run()
    {
        Clinic::create([
            'name' => 'Clinique El Manar',
            'address' => 'Souk Ahras, Algeria',
            'phone' => '+213 550 12 34 56',
            'email' => 'contact@elmanar.dz',
            'location' => '41 - Souk Ahras',
            'description' => 'Leading clinic in Souk Ahras',
            'rating' => 4.8,
        ]);
    }
}