<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 5) as $index) {
            DB::table('staffs')->insert([
                'name' => $faker->name,
                'role' => '0', // Manager
                'image' => 'manager1.jpg', // Placeholder for image filename
                'status' => '1', // Active
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('staffs')->insert([
                'name' => $faker->name,
                'role' => '1', // Manager
                'image' => 'referee1.jpg', // Placeholder for image filename
                'status' => '1', // Active
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('teams')->insert([
            [
                'name' => $faker->company, // Team name as a company name
                'abb' => strtoupper($faker->word(3)), // 3-letter abbreviation
                'logo' => 'team_logo1.png', // Placeholder for team logo
                'home_color_top' => $faker->hexColor, // Random hex color for top home kit
                'home_color_down' => $faker->hexColor, // Random hex color for bottom home kit
                'away_color_top' => $faker->hexColor, // Random hex color for top away kit
                'away_color_down' => $faker->hexColor, // Random hex color for bottom away kit
                'status' => '1', // Active status
                'manager_id' => 1, // Assuming the manager ID for the staff table is 1, change as needed
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => $faker->company, // Team name as a company name
                'abb' => strtoupper($faker->word(3)), // 3-letter abbreviation
                'logo' => 'team_logo2.png', // Placeholder for team logo
                'home_color_top' => $faker->hexColor, // Random hex color for top home kit
                'home_color_down' => $faker->hexColor, // Random hex color for bottom home kit
                'away_color_top' => $faker->hexColor, // Random hex color for top away kit
                'away_color_down' => $faker->hexColor, // Random hex color for bottom away kit
                'status' => '1', // Active status
                'manager_id' => 2, // Assuming the manager ID for the staff table is 2, change as needed
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => $faker->company, // Team name as a company name
                'abb' => strtoupper($faker->word(3)), // 3-letter abbreviation
                'logo' => 'team_logo3.png', // Placeholder for team logo
                'home_color_top' => $faker->hexColor, // Random hex color for top home kit
                'home_color_down' => $faker->hexColor, // Random hex color for bottom home kit
                'away_color_top' => $faker->hexColor, // Random hex color for top away kit
                'away_color_down' => $faker->hexColor, // Random hex color for bottom away kit
                'status' => '1', // Active status
                'manager_id' => 3, // Assuming the manager ID for the staff table is 3, change as needed
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        foreach (range(1, 30) as $index) {
            DB::table('players')->insert([
                'name' => $faker->name,
                'role' => $faker->randomElement(['GK', 'DEF', 'MID', 'FWD']),
                'position' => $faker->word,
                'image' => $faker->imageUrl(),
                'nationality' => $faker->country,
                'height' => $faker->numberBetween(150, 200), // Random height
                'height_unit' => $faker->randomElement(['inches', 'm', 'cm']),
                'weight' => $faker->numberBetween(50, 100), // Random weight
                'weight_unit' => $faker->randomElement(['kg', 'lbs']),
                'age' => $faker->numberBetween(18, 40),
                'status' => $faker->randomElement(['0', '1']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
