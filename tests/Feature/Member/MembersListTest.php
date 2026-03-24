<?php
namespace Tests\Feature\Member;

use App\Models\User;
use App\Models\Membership;
use App\Services\MemberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Member\MembersList;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MembersListTest extends TestCase
{
use RefreshDatabase;

protected MemberService $memberService;

protected function setUp(): void
{
parent::setUp();
$this->memberService = app(MemberService::class);
}

#[Test]
public function no_duplica_usuarios_al_listar()
{
$user = User::factory()->create(['role' => 'member', 'status' => 'active']);

Membership::factory()->count(3)->create(['user_id' => $user->id]);

$result = $this->memberService->getPaginatedList();

$this->assertEquals(1, $result->total());
}

#[Test]
public function filtra_miembros_por_estado_administrativo()
{

User::factory()->create(['status' => 'active', 'role' => 'member', 'first_name' => 'Activo']);
User::factory()->create(['status' => 'inactive', 'role' => 'member', 'first_name' => 'Inactivo']);
User::factory()->create(['status' => 'pending', 'role' => 'member', 'first_name' => 'Pendiente']);


$result = $this->memberService->getPaginatedList('', 'inactive');

$this->assertEquals(1, $result->total());
$this->assertEquals('Inactivo', $result->first()->first_name);
}

#[Test]
public function las_estadisticas_reflejan_los_estados_administrativos()
{
User::factory()->count(2)->create(['status' => 'active', 'role' => 'member']);
User::factory()->count(3)->create(['status' => 'pending', 'role' => 'member']);

$stats = $this->memberService->getMembersStats();

$this->assertEquals(2, $stats['active']);
$this->assertEquals(3, $stats['pending']);
$this->assertEquals(5, $stats['total']);
}

#[Test]
public function el_componente_livewire_responde_a_los_filtros()
{
User::factory()->create(['first_name' => 'Gustavo', 'status' => 'active', 'role' => 'member']);

Livewire::test(MembersList::class)
->set('statusFilter', 'active')
->assertSee('Gustavo')
->set('statusFilter', 'inactive')
->assertDontSee('Gustavo');
}
}
