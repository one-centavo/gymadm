<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MembershipPlan;
use App\Models\Membership;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->count(5)->create();


        MembershipPlan::factory()->count(3)->create();


        Membership::factory()->count(10)->create();


        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'admin@gymadm.com',
            'password' => bcrypt('password'), // Asegúrate de poner una clave que recuerdes
        ]);
    }
}
