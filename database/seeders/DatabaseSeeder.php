<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PropertySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Property::factory()->count(152)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        /*Property::factory()->create([
            'title' => 'Starter appartement centrum',
            'city'  => 'Amsterdam',
            'status'=> 'available',
            'price' => 325000,
        ]);*/
    }
}
