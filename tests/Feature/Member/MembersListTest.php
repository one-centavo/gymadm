<?php

namespace Tests\Feature\Member;

use App\Models\User;
use App\Models\Membership;
use App\Services\MemberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Member\MembersList;
use Tests\TestCase;

class MembersListTest extends TestCase
{
    use RefreshDatabase;

    protected MemberService $memberService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->memberService = app(MemberService::class);
    }

    public function test_it_does_not_duplicate_users_with_multiple_memberships()
    {
        $user = User::factory()->create([
            'first_name' => 'Kirk',
            'role' => 'member'
        ]);

        Membership::factory()->count(3)->create([
            'user_id' => $user->id
        ]);

        $result = $this->memberService->getPaginatedList();

        $this->assertEquals(1, $result->total(), 'El bug de duplicados sigue presente');
        $this->assertEquals('Kirk', $result->first()->first_name);
    }

    public function test_it_filters_members_by_search_term()
    {
        User::factory()->create(['first_name' => 'Kirk', 'document_number' => '3272428908', 'role' => 'member']);
        User::factory()->create(['first_name' => 'Hobart', 'document_number' => '9853316079', 'role' => 'member']);

        $result = $this->memberService->getPaginatedList('Hobart');

        $this->assertEquals(1, $result->total());
        $this->assertEquals('Hobart', $result->first()->first_name);
    }

    public function test_livewire_component_renders_and_wires_search_property()
    {
        User::factory()->create(['first_name' => 'Alvah', 'role' => 'member']);

        Livewire::test(MembersList::class)
            ->assertOk()
            ->assertViewIs('livewire.member.members-list')
            ->set('search', 'Alvah')
            ->assertSee('Alvah');
    }
}
