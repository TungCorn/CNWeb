<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MedicinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for($i = 0; $i < 10; $i++){
            Medicine::create([
                'name' => $faker->company(),
                'brand' => $faker->company(),
                'dosage' => $faker->randomElement(['10mg', '20mg', '50mg', '100mg']),
                'form' => $faker->randomElement(['tablet', 'capsule', 'syrup', 'injection']),
                'price' => $faker->randomFloat(2, 5, 500),
                'stock' => $faker->numberBetween(0, 100),
            ]);
        }
    }
}
