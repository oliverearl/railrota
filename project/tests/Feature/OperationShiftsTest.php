<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OperationShiftsTest extends TestCase
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
     * Returns a shift factory to either create or make
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    protected function createShift()
    {
        return factory('App\OperationShift');
    }

    /**
     * It would be impractical to be able to view all the shifts without the
     * operation context. So it redirects back to the operations index.
     */
    public function test_the_operation_shifts_index_redirects_to_the_operations_index()
    {
        $this->actingAs($this->user);

        $shift = $this->createShift()->create();

        $response = $this->get(route('operations.shifts.index', $shift->operation->id));

        $response->assertRedirect(route('operations.index'));
    }

    /**
     * Again, shifts should be seen only with their operations.
     */
    public function test_an_operation_shift_redirects_to_its_parent_operation()
    {
        $this->actingAs($this->user);

        $shift = $this->createShift()->create();

        $response = $this->get(route('operations.shifts.show', [$shift->operation->id, $shift->id]));

        $response->assertRedirect(route('operations.show', $shift->operation->id));
    }

    /**
     * Users with a competency level can also register for shifts where the competency requirement is unspecified.
     */
    public function test_a_user_with_a_competency_can_register_for_an_operation_shift_without_a_competency_with_the_right_role_type()
    {
        $this->actingAs($this->user);

        $roleType = factory('App\RoleType')->create();
        $roleCompetency = factory('App\RoleCompetency')->create();
        $role = factory('App\Role')->create([
            'user_id' => $this->user->id,
            'role_type_id' => $roleType->id,
            'role_competency_id' => $roleCompetency->id
        ]);
        $shift = $this->createShift()->create([
            'role_type_id' => $roleType->id,
            'role_competency_id' => null,
        ]);

        $response = $this->patch(route('operations.shifts.register', [$shift->operation_id, $shift->id]));
        $response->assertRedirect();
        $this->assertDatabaseHas('operation_shifts', [
            'id' => $shift->id,
            'operation_id' => $shift->operation->id,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * As long as a user has a tier equal or above the requirement, they can sign up for a shift autonomously.
     */
    public function test_a_user_with_a_competency_can_register_for_an_operation_shift_with_adequate_competency_with_the_right_role_type()
    {
        $this->actingAs($this->user);

        $roleType = factory('App\RoleType')->create();
        $roleCompetency = factory('App\RoleCompetency')->create();
        $role = factory('App\Role')->create([
            'user_id' => $this->user->id,
            'role_type_id' => $roleType->id,
            'role_competency_id' => $roleCompetency->id
        ]);
        $shift = $this->createShift()->create([
            'role_type_id' => $roleType->id,
            'role_competency_id' => $roleCompetency->id, // same tier, but equal to or above will work
        ]);

        $response = $this->patch(route('operations.shifts.register', [$shift->operation_id, $shift->id]));
        $response->assertRedirect();
        $this->assertDatabaseHas('operation_shifts', [
            'id' => $shift->id,
            'operation_id' => $shift->operation->id,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * Checks that users that do not have assigned competencies can register for a shift also without a competency level.
     * They must still have the correct role type.
     */
    public function test_a_user_without_a_competency_can_register_for_an_operation_shift_without_a_competency_with_the_right_role_type()
    {
        $this->actingAs($this->user);

        $roleType = factory('App\RoleType')->create();
        $role = factory('App\Role')->create([
            'user_id' => $this->user->id,
            'role_type_id' => $roleType->id
        ]);
        $shift = $this->createShift()->create([
            'role_type_id' => $roleType->id,
            'role_competency_id' => null,
        ]);

        $response = $this->patch(route('operations.shifts.register', [$shift->operation_id, $shift->id]));
        $response->assertRedirect();
        $this->assertDatabaseHas('operation_shifts', [
            'id' => $shift->id,
            'operation_id' => $shift->operation->id,
            'user_id' => $this->user->id
        ]);
    }

    /**
     * When a competency requirement is specified, users without one cannot register for said shift.
     */
    public function test_a_user_without_a_competency_cannot_register_for_an_operation_shift_with_the_right_role_type()
    {
        $this->actingAs($this->user);

        $roleType = factory('App\RoleType')->create();
        $role = factory('App\Role')->create([
            'user_id' => $this->user->id,
            'role_type_id' => $roleType->id
        ]);
        $shift = $this->createShift()->create();

        $response = $this->patch(route('operations.shifts.register', [$shift->operation_id, $shift->id]));
        $response->assertRedirect();
        $this->assertDatabaseMissing('operation_shifts', [
            'id' => $shift->id,
            'operation_id' => $shift->operation->id,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * Regardless of competency level, a user cannot volunteer if they simply aren't trained in that specific role type.
     */
    public function test_a_user_cannot_register_for_an_operation_shift_without_the_right_role_type()
    {
        $this->actingAs($this->user);
        $roleType = factory('App\RoleType')->create();
        $differentRoleType = null;

        // Ensure we get a different role type, or we get potentially oof'd by RNG.
        do {
            $differentRoleType = factory('App\RoleType')->create();
        } while($differentRoleType === $roleType);

        $role = factory('App\Role')->create([
            'user_id' => $this->user->id,
            'role_type_id' => $roleType->id,
        ]);
        $shift = $this->createShift()->create(['role_type_id' => $differentRoleType->id]);

        $response = $this->patch(route('operations.shifts.register', [$shift->operation_id, $shift->id]));
        $response->assertRedirect();
        $this->assertDatabaseMissing('operation_shifts', [
            'id' => $shift->id,
            'operation_id' => $shift->operation->id,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * Shifts with a user already present cannot be overrode by someone else wishing to register.
     */
    public function test_a_user_cannot_register_for_an_occupied_operation_shift()
    {
        $this->actingAs($this->user);

        $roleType = factory('App\RoleType')->create();
        $role = factory('App\Role')->create([
            'user_id' => $this->user->id,
            'role_type_id' => $roleType->id
        ]);
        $shift = $this->createShift()->create(['user_id' => factory('App\User')->create()->id]);

        $response = $this->patch(route('operations.shifts.register', [$shift->operation_id, $shift->id]));
        $response->assertRedirect();
        $this->assertDatabaseMissing('operation_shifts', [
            'id' => $shift->id,
            'operation_id' => $shift->operation->id,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * Users can deregister from shifts that they are signed up on.
     */
    public function test_a_user_can_pull_out_of_a_shift_that_they_have_registered_for()
    {
        $this->actingAs($this->user);
        $roleType = factory('App\RoleType')->create();
        $role = factory('App\Role')->create([
            'user_id' => $this->user->id,
            'role_type_id' => $roleType->id
        ]);
        $shift = $this->createShift()->create([
            'role_type_id' => $roleType->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->patch(route('operations.shifts.deregister', [$shift->operation_id, $shift->id]));
        $response->assertRedirect();
        $this->assertDatabaseHas('operation_shifts', [
            'id' => $shift->id,
            'operation_id' => $shift->operation->id,
            'user_id' => null
        ]);
    }

    /**
     * Users cannot deregister from shifts that someone else is signed up on.
     */
    public function test_a_user_cannot_pull_out_of_a_shift_that_is_occupied_by_someone_else()
    {
        $this->actingAs($this->user);
        $roleType = factory('App\RoleType')->create();
        $role = factory('App\Role')->create([
            'user_id' => $this->user->id,
            'role_type_id' => $roleType->id
        ]);

        $shift = $this->createShift()->create([
            'role_type_id' => $roleType->id,
            'user_id' => factory('App\User')->create()->id,
        ]);

        $response = $this->patch(route('operations.shifts.deregister', [$shift->operation_id, $shift->id]));
        $response->assertForbidden();
        $this->assertDatabaseMissing('operation_shifts', [
            'id' => $shift->id,
            'operation_id' => $shift->operation->id,
            'user_id' => $this->user->id
        ]);
    }

    /**
     * Users cannot deregister from vacant shifts.
     */
    public function test_a_user_cannot_pull_out_of_a_vacant_shift()
    {
        $this->actingAs($this->user);
        $roleType = factory('App\RoleType')->create();
        $role = factory('App\Role')->create([
            'user_id' => $this->user->id,
            'role_type_id' => $roleType->id
        ]);

        $shift = $this->createShift()->create([
            'role_type_id' => $roleType->id,
            'user_id' => null,
        ]);

        $response = $this->patch(route('operations.shifts.deregister', [$shift->operation_id, $shift->id]));
        $response->assertForbidden();
        $this->assertDatabaseMissing('operation_shifts', [
            'id' => $shift->id,
            'operation_id' => $shift->operation->id,
            'user_id' => $this->user->id
        ]);
    }

    /**
     * Users cannot create their own operation shifts.
     */
    public function test_a_user_cannot_store_an_operation_shift()
    {
        $this->actingAs($this->user);
        $shift = $this->createShift()->make();

        $response = $this->post(route('operations.shifts.store', [$shift->operation->id, $shift->id]), $shift->toArray());

        $response->assertForbidden();
        $this->assertDatabaseMissing('operation_shifts', [
            'operation_id' => $shift->operation->id,
            'user_id' => $shift->user_id,
        ]);
    }

    public function test_a_user_cannot_update_an_operation_shift()
    {
        $this->actingAs($this->user);
        $shift = $this->createShift()->create();

        $shift->user_id = factory('App\User')->create()->id;
        $shift->notes = 'New Notes';

        $response = $this->patch(route('operations.shifts.update', [$shift->operation->id, $shift->id]), $shift->toArray());

        $response->assertForbidden();
        $this->assertDatabaseMissing('operation_shifts', [
            'operation_id' => $shift->operation->id,
            'user_id' => $shift->user_id,
            'notes' => $shift->notes,
        ]);
    }

    /**
     * Users cannot delete operation shifts.
     */
    public function test_a_user_cannot_destroy_an_operation_shift()
    {
        $this->actingAs($this->user);

        $shift = $this->createShift()->create();

        $response = $this->delete(route('operations.shifts.destroy', [$shift->operation->id, $shift->id]));
        $response->assertForbidden();
        $this->assertDatabaseHas('operation_shifts', ['id' => $shift->id]);
    }

    /**
     * Admins can create new shifts.
     */
    public function test_an_admin_can_store_an_operation_shift()
    {
        $this->actingAs($this->admin);
        $shift = $this->createShift()->make();

        $response = $this->post(route('operations.shifts.store', [$shift->operation->id, $shift->id]), $shift->toArray());

        $response->assertRedirect();
        $this->assertDatabaseHas('operation_shifts', [
            'operation_id' => $shift->operation->id,
            'user_id' => $shift->user_id,
        ]);
    }

    /**
     * Admins can modify existing operation shifts.
     */
    public function test_an_admin_can_update_an_operation_shift()
    {
        $this->actingAs($this->admin);
        $shift = $this->createShift()->create();

        $shift->user_id = factory('App\User')->create()->id;
        $shift->notes = 'New Notes';

        $response = $this->patch(route('operations.shifts.update', [$shift->operation->id, $shift->id]), $shift->toArray());

        $response->assertRedirect();
        $this->assertDatabaseHas('operation_shifts', [
            'operation_id' => $shift->operation->id,
            'user_id' => $shift->user_id,
            'notes' => $shift->notes,
        ]);
    }

    /**
     * Admins can delete operation shifts.
     */
    public function test_an_admin_can_destroy_an_operation_shift()
    {
        $this->actingAs($this->admin);

        $shift = $this->createShift()->create();

        $response = $this->delete(route('operations.shifts.destroy', [$shift->operation->id, $shift->id]));
        $response->assertRedirect();
        $this->assertDatabaseMissing('operation_shifts', ['id' => $shift->id]);
    }

    /**
     * Admins can do whatever they want. Role Types and Competencies mean nothing to them.
     */
    public function test_an_admin_can_register_for_an_operation_shift_irrespective_of_competencies_and_role_type()
    {
        $this->actingAs($this->admin);

        $roleType = factory('App\RoleType')->create();
        $role = factory('App\Role')->create([
            'user_id' => $this->admin->id,
            'role_type_id' => $roleType->id,
        ]);

        $shift = $this->createShift()->create([
            'role_type_id' => factory('App\RoleType')->create()->id,
        ]);

        $response = $this->patch(route('operations.shifts.register', [$shift->operation_id, $shift->id]));
        $response->assertRedirect();
        $this->assertDatabaseHas('operation_shifts', [
            'id' => $shift->id,
            'operation_id' => $shift->operation->id,
            'user_id' => $this->admin->id,
        ]);
    }
}
