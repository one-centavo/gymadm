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
        // 1. PLANES BASE
        $planes = MembershipPlan::factory()->count(3)->create();

        // 2. ADMINISTRADOR SISTEMA
        User::factory()->admin()->create([
            'first_name' => 'Admin',
            'last_name' => 'GYMADM',
            'email' => 'admin@gymadm.com',
        ]);

        // 3. MIEMBRO ACTIVO
        $userActive = User::factory()->member()->create([
            'first_name' => 'Juan',
            'last_name' => 'Activo',
            'email' => 'active@gymadm.com',
        ]);

        Membership::factory()
            ->active()
            ->for($userActive)
            ->for($planes->random())
            ->create();

        // 4. MIEMBRO VENCIDO
        $userExpired = User::factory()->member()->create([
            'first_name' => 'Pedro',
            'last_name' => 'Vencido',
            'email' => 'expired@gymadm.com',
        ]);

        Membership::factory()
            ->expired()
            ->for($userExpired)
            ->for($planes->random())
            ->create();

        // 5. MIEMBRO PENDIENTE
        User::factory()->member()->create([
            'first_name' => 'Santi',
            'last_name' => 'Pendiente',
            'email' => 'pending@gymadm.com',
        ]);


        User::factory()
            ->count(20)
            ->has(
                Membership::factory()
                    ->recycle($planes)
                    ->state(fn () => [
                        'status' => fake()->randomElement(['active', 'inactive'])
                    ])
            )
            ->create();

        // FEEDBACK EN CONSOLA
        $this->command->info('-------------------------------------------');
        $this->command->warn('¡GYMADM Seeded con éxito!');
        $this->command->line('Contraseña universal: password');
        $this->command->line("- admin@gymadm.com");
        $this->command->line("- active@gymadm.com (AZUL)");
        $this->command->line("- expired@gymadm.com (ROSA)");
        $this->command->line("- pending@gymadm.com (NARANJA)");
        $this->command->info('-------------------------------------------');
    }
}
