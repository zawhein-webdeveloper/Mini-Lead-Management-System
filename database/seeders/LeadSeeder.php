<?php

namespace Database\Seeders;

use App\Models\Lead;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Match the enum values defined in the migration
        $statuses = ['new', 'in_progress', 'closed'];

        $records = [];
        for ($i = 0; $i < 100; $i++) {
            $name = $faker->name();
            $email = $faker->unique()->safeEmail();
            $phone = $faker->phoneNumber();
            $status = $faker->randomElement($statuses);

            $records[] = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert in a single query for performance
        Lead::insert($records);
    }
}
