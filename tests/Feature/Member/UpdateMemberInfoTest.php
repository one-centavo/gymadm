<?php
namespace Tests\Feature\Member;

use App\Livewire\Member\UpdateMemberInfo;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class UpdateMemberInfoTest extends TestCase
{
use RefreshDatabase;

#[Test]
public function debe_cargar_los_datos_del_miembro_al_recibir_el_evento()
{
$member = User::factory()->create([
'first_name' => 'Carlos',
'email' => 'carlos@example.com'
]);


Livewire::test(UpdateMemberInfo::class)
->dispatch('open-edit-drawer', id: $member->id)
->assertSet('first_name', 'Carlos')
->assertSet('email', 'carlos@example.com')
->assertSet('memberId', (string)$member->id)
->assertSet('open', true);
}

#[Test]
public function debe_actualizar_la_informacion_correctamente()
{
$member = User::factory()->create([
'first_name' => 'Nombre Antiguo', 'last_name' => 'Apellido Valido'
]);

Livewire::test(UpdateMemberInfo::class)
->dispatch('open-edit-drawer', id: $member->id)
->set('first_name', 'Nombre Nuevo')
->call('update')
->assertHasNoErrors()
->assertDispatched('member-updated')
->assertSet('open', false);


$this->assertDatabaseHas('users', [
'id' => $member->id,
'first_name' => 'Nombre Nuevo'
]);
}

#[Test]
public function no_debe_chocar_con_su_propio_email_al_actualizar()
{
$member = User::factory()->create([
'email' => 'original@example.com',
'document_number' => '12345'
]);

// Probamos que si no cambiamos el email, la validación pase (Ignore ID)
Livewire::test(UpdateMemberInfo::class)
->dispatch('open-edit-drawer', id: $member->id)
->call('update')
->assertHasNoErrors();
}

#[Test]
public function debe_fallar_la_validacion_si_el_email_ya_lo_tiene_otro_usuario()
{
User::factory()->create(['email' => 'ocupado@example.com']);
$member = User::factory()->create(['email' => 'miembro@example.com']);

Livewire::test(UpdateMemberInfo::class)
->dispatch('open-edit-drawer', id: $member->id)
->set('email', 'ocupado@example.com')
->call('update')
->assertHasErrors(['email' => 'unique']);
}
}
