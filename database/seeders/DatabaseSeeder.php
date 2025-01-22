<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\AdminSeeder;
use Database\Seeders\BasicFormSeeder;
use Database\Seeders\BusinessFormSeeder;
use Database\Seeders\MedicalFormSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            BasicFormSeeder::class,
            BusinessFormSeeder::class,
            MedicalFormSeeder::class,
        ]);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
