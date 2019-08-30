<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UsersTest extends TestCase
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
     * Check to see whether basic auth is working and users cannot be seen.
     */
    public function test_a_guest_cannot_view_all_the_users()
    {
        $response = $this->get(route('users.index'));

        $response->assertRedirect(route('login'));
        $response->assertSee('login');
    }

    /**
     * Tests whether a user can view the user index. This is viewable by all
     * authenticated users.
     */
    public function test_a_user_can_view_all_users()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('users.index'));

        $response->assertSee($this->user->name);
        $response->assertSee($this->user->email);
    }

    /**
     * Tests whether a user can view another user's profile.
     * Both their own, and other users' profiles are viewable by
     * all user tiers.
     */
    public function test_a_user_can_view_a_user()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('users.show', $this->user->id));

        $response->assertSee($this->user->name);
        $response->assertSee($this->user->email);
    }

    /**
     * Checks to ensure that non-administrator users cannot
     * create new users themselves.
     */
    public function test_a_user_cannot_store_a_user()
    {
        $this->actingAs($this->user);

        $newUser = factory('App\User')->make();
        $data = array_merge($newUser->makeVisible('password')->toArray(), ['password_confirmation' => $newUser->password]);
        $response = $this->post(route('users.store'), $data);

        $response->assertForbidden();
    }

    /**
     * Checks to ensure whether users can update their own profiles.
     */
    public function test_a_user_can_update_themselves()
    {
        $this->actingAs($this->user);

        $this->user->name = 'Updated Name';
        $this->user->surname = 'Updated Surname';

        $this->patch(route('users.update', $this->user->id), $this->user->toArray());
        $this->assertDatabaseHas('users', ['id' => $this->user->id, 'name' => $this->user->name, 'surname' => $this->user->surname]);
    }


    /**
     * Checks to ensure users cannot give themselves administrative powers
     *
     * A complete new user is generated to test this due to some RNG issues.
     */
    public function test_a_user_cannot_give_themselves_administrative_privileges()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $data = $user->toArray();
        $data['is_admin'] = 1;

        $response = $this->patch(route('users.update', $user->id), $data);
        $response->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'is_admin' => 0]);
    }

    /**
     * Checks to ensure users cannot modify their last inspection date.
     *
     * Like the last test, the validation that has been set up is awful, so this builds
     * its own user, just in case.
     */
    public function test_a_user_cannot_modify_their_own_date_of_last_inspection()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $data = $user->toArray();
        $data['date_of_last_last_inspection'] = Carbon::today();

        $response = $this->patch(route('users.update', $user->id), $data);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'date_of_last_inspection' => null]);
    }

    /**
     * Checks to ensure that users cannot modify other users' profiles.
     * Only administrators can do that.
     */
    public function test_a_user_cannot_update_a_different_user()
    {
        $this->actingAs($this->user);

        $user = factory('App\User')->create();

        $user->name = 'Updated Name';
        $user->surname = 'Updated Surname';

        $response = $this->patch(route('users.update', $user->id), $user->toArray());
        $response->assertForbidden();
        $this->assertNotEquals(1, \App\User::where([
            ['name', '=', $user->name],
            ['description', '=', $user->surname],
        ])->count());
    }

    /**
     * Checks to ensure that users cannot access destroy functionality on users.
     * Regardless of whether themselves, or another user.
     */
    public function test_a_user_cannot_destroy_a_user()
    {
        $this->actingAs($this->user);

        $user = factory('App\User')->create();

        $response = $this->delete(route('users.destroy', $user->id));
        $response->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => $user->email]);
    }

    /**
     * Checks to ensure that administrators can create new users.
     * This can be used in addition with the usual site registration functionality.
     */
    public function test_an_admin_can_store_a_user()
    {
        $this->actingAs($this->admin);

        $newUser = factory('App\User')->make();
        $data = array_merge($newUser->makeVisible('password')->toArray(), ['password_confirmation' => $newUser->password]);
        $response = $this->post(route('users.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => $newUser->email]);
    }

    /**
     * Checks to ensure that admins can modify other users, in addition to their
     * own profiles.
     */
    public function test_an_admin_can_update_a_user()
    {
        $this->actingAs($this->admin);

        $user = factory('App\User')->create();

        $user->name = 'Updated Name';
        $user->surname = 'Updated Surname';

        $response = $this->patch(route('users.update', $user->id), $user->toArray());
        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'surname' => $user->surname,
        ]);
    }

    /**
     * Admins can delete other users, and this checks to ensure
     * that this functionality is intact.
     */
    public function test_an_admin_can_destroy_a_user()
    {
        $this->actingAs($this->admin);

        $user = factory('App\User')->create();

        $response = $this->delete(route('users.destroy', $user->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $user->id, 'email' => $user->email]);
    }

    /**
     * Although administrators can delete other users, they should not
     * be able to delete themselves. They can delete other admins, however.
     */
    public function test_an_admin_cannot_destroy_themselves()
    {
        $this->actingAs($this->admin);

        $this->delete(route('users.destroy', $this->admin->id));
        $this->assertDatabaseHas('users', ['id' => $this->admin->id, 'email' => $this->admin->email]);
    }
}
