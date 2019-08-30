<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RoleCompetenciesTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $admin;

    /**
     * Test setup
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
        $this->admin = factory('App\User')->create(['is_admin' => 1]);
    }

    /**
     * Guests cannot view the role competencies index.
     */
    public function test_a_guest_cannot_view_role_competencies()
    {
        $response = $this->get(route('role_competencies.index'));

        $response->assertRedirect(route('login'));
        $response->assertSee('login');
    }

    /**
     * Users can view role competencies.
     */
    public function test_a_user_can_view_role_competencies()
    {
        $this->actingAs($this->user);
        $roleCompetency = factory('App\RoleCompetency')->create();

        $response = $this->get(route('role_competencies.index'));

        $response->assertSee(htmlspecialchars($roleCompetency->name));
    }

    /**
     * Users can view individual role competencies.
     */
    public function test_a_user_can_view_a_role_competency()
    {
        $this->actingAs($this->user);
        $roleCompetency = factory('App\RoleCompetency')->create();

        $response = $this->get(route('role_competencies.show', $roleCompetency->id));

        $response->assertSee($roleCompetency->name);
    }

    /**
     * Users cannot add their own role competencies.
     */
    public function test_a_user_cannot_store_a_role_competency()
    {
        $this->actingAs($this->user);

        $roleCompetency = factory('App\RoleCompetency')->make();
        $response = $this->post(route('role_competencies.store'), $roleCompetency->toArray());

        $response->assertForbidden();
        $this->assertDatabaseMissing('role_competencies', [
            'name' => $roleCompetency->name,
            'description' => $roleCompetency->description
        ]);
    }

    /**
     * Users cannot edit existing role competencies.
     */
    public function test_a_user_cannot_update_a_role_competency()
    {
        $this->actingAs($this->user);

        $roleCompetency = factory('App\RoleCompetency')->create();

        $roleCompetency->name = 'Updated Name';
        $roleCompetency->description = 'Updated Description';

        $response = $this->patch(route('role_competencies.update', $roleCompetency->id), $roleCompetency->toArray());
        $response->assertForbidden();
        $this->assertNotEquals(1, \App\RoleCompetency::where([
            ['name', '=', $roleCompetency->name],
            ['description', '=', $roleCompetency->description],
        ])->count());
    }

    /**
     * Users cannot delete competencies.
     */
    public function test_a_user_cannot_destroy_a_role_competency()
    {
        $this->actingAs($this->user);

        $roleCompetency = factory('App\RoleCompetency')->create();

        $response = $this->delete(route('role_competencies.destroy', $roleCompetency->id));
        $response->assertForbidden();
        $this->assertDatabaseHas('role_competencies', ['id' => $roleCompetency->id]);
    }

    /**
     * Admins can add custom competencies to role types.
     */
    public function test_an_admin_can_store_a_role_competency()
    {
        $this->actingAs($this->admin);

        $roleCompetency = factory('App\RoleCompetency')->make();
        $response = $this->post(route('role_competencies.store'), $roleCompetency->toArray());

        $response->assertRedirect(route('role_competencies.index'));
        $this->assertDatabaseHas('role_competencies', ['name' => $roleCompetency->name, 'description' => $roleCompetency->description]);
    }

    /**
     * Admins can update existing role competencies.
     */
    public function test_an_admin_can_update_a_role_competency()
    {
        $this->actingAs($this->admin);

        $roleCompetency = factory('App\RoleCompetency')->create();

        $roleCompetency->name = 'Updated Name';
        $roleCompetency->description = 'Updated Description';

        $response = $this->patch(route('role_competencies.update', $roleCompetency->id), $roleCompetency->toArray());
        $response->assertRedirect();
        $this->assertDatabaseHas('role_competencies', [
            'id' => $roleCompetency->id,
            'name' => $roleCompetency->name,
            'description' => $roleCompetency->description,
        ]);
    }

    /**
     * Admins can delete redundant competencies.
     */
    public function test_an_admin_can_destroy_a_role_competency()
    {
        $this->actingAs($this->admin);

        $roleCompetency = factory('App\RoleCompetency')->create();

        $response = $this->delete(route('role_competencies.destroy', $roleCompetency->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('role_competencies', ['id' => $roleCompetency->id]);
    }
}
