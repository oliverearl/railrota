<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RoleTypesTest extends TestCase
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
     * Guests cannot view the role types index.
     */
    public function test_a_guest_cannot_view_role_types()
    {
        $response = $this->get(route('role_types.index'));

        $response->assertRedirect(route('login'));
        $response->assertSee('login');
    }

    /**
     * Users can view role types when they're logged in.
     */
    public function test_a_user_can_view_all_role_types()
    {
        $this->actingAs($this->user);
        $roleType = factory('App\RoleType')->create();

        $response = $this->get(route('role_types.index'));

        $response->assertSee($roleType->name);
    }

    /**
     * An individual role type can be viewed by authenticated users.
     */
    public function test_a_user_can_view_a_role_type()
    {
        $this->actingAs($this->user);
        $roleType = factory('App\RoleType')->create();

        $response = $this->get(route('role_types.show', $roleType->id));

        $response->assertSee($roleType->name);
    }

    /**
     * Users cannot store new role types.
     */
    public function test_a_user_cannot_store_a_role_type()
    {
        $this->actingAs($this->user);

        $newRoleType = factory('App\RoleType')->make();
        $response = $this->post(route('role_types.store'), $newRoleType->toArray());

        $response->assertForbidden();
        $this->assertDatabaseMissing('role_types', [
            'name' => $newRoleType->name,
            'description' => $newRoleType->description
        ]);
    }

    /**
     * Users must not be able to update or modify role types.
     */
    public function test_a_user_cannot_update_a_role_type()
    {
        $this->actingAs($this->user);

        $roleType = factory('App\RoleType')->create();

        $roleType->name = 'Updated Name';
        $roleType->description = 'Updated Description';

        $response = $this->patch(route('role_types.update', $roleType->id), $roleType->toArray());
        $response->assertForbidden();
        $this->assertNotEquals(1, \App\RoleType::where([
            ['name', '=', $roleType->name],
            ['description', '=', $roleType->description],
        ])->count());
    }

    /**
     * Users must not be able to delete role types.
     */
    public function test_a_user_cannot_destroy_a_role_type()
    {
        $this->actingAs($this->user);

        $roleType = factory('App\RoleType')->create();

        $response = $this->delete(route('users.destroy', $roleType->id));
        $response->assertForbidden();
        $this->assertDatabaseHas('role_types', ['id' => $roleType->id]);
    }

    /**
     * An administrator can create a new custom role type.
     */
    public function test_an_admin_can_store_a_role_type()
    {
        $this->actingAs($this->admin);

        $newRoleType = factory('App\RoleType')->make();
        $response = $this->post(route('role_types.store'), $newRoleType->toArray());

        $response->assertRedirect(route('role_types.index'));
        $this->assertDatabaseHas('role_types', ['name' => $newRoleType->name, 'description' => $newRoleType->description]);
    }

    /**
     * An administrator can update an existing role type.
     */
    public function test_an_admin_can_update_a_role_type()
    {
        $this->actingAs($this->admin);

        $roleType = factory('App\RoleType')->create();

        $roleType->name = 'Updated Name';
        $roleType->description = 'Updated Description';

        $response = $this->patch(route('role_types.update', $roleType->id), $roleType->toArray());
        $response->assertRedirect();
        $this->assertDatabaseHas('role_types', [
            'id' => $roleType->id,
            'name' => $roleType->name,
            'description' => $roleType->description,
        ]);
    }

    /**
     * An administrator can delete an existing role type.
     */
    public function test_an_admin_can_delete_a_role_type()
    {
        $this->actingAs($this->admin);

        $roleType = factory('App\RoleType')->create();

        $response = $this->delete(route('role_types.destroy', $roleType->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('role_types', ['id' => $roleType->id]);
    }
}
