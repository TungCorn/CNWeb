<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $medicineIds = Medicine::pluck('medicine_id')->toArray();
        for ($i = 0; $i < 10; $i++) {
            Sale::create([
                'medicine_id' => $faker->randomElement($medicineIds),
                'quantity' => $faker->numberBetween(0, 100),
                'customer_phone' => $faker->phoneNumber,
            ]);
        }
    }
}
