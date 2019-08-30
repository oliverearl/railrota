<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RolesTest extends TestCase
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
     * Guests cannot view roles.
     */
    public function test_a_guest_cannot_view_roles()
    {
        $response = $this->get(route('roles.index'));

        $response->assertRedirect(route('login'));
        $response->assertSee('login');
    }

    /**
     * Users can view a list of roles.
     */
    public function test_a_user_can_view_roles()
    {
        $this->actingAs($this->user);
        $role = factory('App\Role')->create();

        $response = $this->get(route('roles.index'));

        $response->assertSee(htmlspecialchars($role->role_type->name));
    }

    /**
     * Users can view individual roles.
     */
    public function test_a_user_can_view_a_role()
    {
        $this->actingAs($this->user);
        $role = factory('App\Role')->create();

        $response = $this->get(route('roles.show', $role->id));

        $response->assertSee($role->role_type->name);
    }

    /**
     * Users cannot save roles.
     */
    public function test_a_user_cannot_store_a_role()
    {
        $this->actingAs($this->user);

        $user = factory('App\User')->create();
        $roleType = factory('App\RoleType')->create();

        $role = factory('App\Role')->make();
        $role->user_id = $user->id;
        $role->role_type_id = $roleType->id;
        $response = $this->post(route('roles.store'), $role->toArray());

        $response->assertForbidden();
        $this->assertDatabaseMissing('roles', [
            'user_id' => $role->user_id,
            'role_type_id' => $role->role_type_id,
        ]);
    }

    /**
     * Users cannot update a role.
     */
    public function test_a_user_cannot_update_a_role()
    {
        $this->actingAs($this->user);

        $role = factory('App\Role')->create();
        $newCompetency = factory('App\RoleCompetency')->create(['role_type_id' => $role->role_type_id]);

        $role->role_competency_id = $newCompetency->id;

        $response = $this->patch(route('roles.update', $role->id), $role->toArray());
        $response->assertForbidden();
        $this->assertNotEquals(1, \App\Role::where([
            ['id', '=', $role->id],
            ['role_competency_id', '=', $role->role_competency_id],
        ])->count());
    }

    /**
     * Users cannot delete roles.
     */
    public function test_a_user_cannot_destroy_a_role()
    {
        $this->actingAs($this->user);

        $role = factory('App\Role')->create();

        $response = $this->delete(route('roles.destroy', $role->id));
        $response->assertForbidden();
        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }

    /**
     * Admins can create new roles
     */
    public function test_an_admin_can_store_a_role()
    {
        $this->actingAs($this->admin);

        $user = factory('App\User')->create();
        $roleType = factory('App\RoleType')->create();

        $role = factory('App\Role')->make();
        $role->user_id = $user->id;
        $role->role_type_id = $roleType->id;
        $response = $this->post(route('roles.store'), $role->toArray());

        $response->assertRedirect();
        $this->assertDatabaseHas('roles', [
            'user_id' => $role->user_id,
            'role_type_id' => $role->role_type_id
        ]);
    }

    /**
     * Admins can update roles. Sorta. It could honestly use with refactoring.
     * This route is how to add a competency to the role.
     */
    public function test_an_admin_can_update_a_role()
    {
        $this->actingAs($this->admin);

        $role = factory('App\Role')->create();
        $newCompetency = factory('App\RoleCompetency')->create(['role_type_id' => $role->role_type_id]);

        $role->role_competency_id = $newCompetency->id;

        $response = $this->patch(route('roles.update', $role->id), $role->toArray());
        $response->assertRedirect();
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'role_competency_id' => $role->role_competency_id,
        ]);
    }

    public function test_an_admin_can_destroy_a_role()
    {
        $this->actingAs($this->admin);

        $role = factory('App\Role')->create();

        $response = $this->delete(route('roles.destroy', $role->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    public function test_an_admin_cannot_create_roles_outside_a_user_edit_view()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('roles.create'));
        $response->assertRedirect();
    }
}
