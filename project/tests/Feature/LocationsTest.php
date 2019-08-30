<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LocationsTest extends TestCase
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
     * Guests cannot view locations.
     */
    public function test_a_guest_cannot_view_locations()
    {
        $response = $this->get(route('locations.index'));

        $response->assertRedirect(route('login'));
        $response->assertSee('login');
    }

    /**
     * Users can view all locations.
     */
    public function test_a_user_can_view_all_locations()
    {
        $this->actingAs($this->user);
        $location = factory('App\Location')->create();

        $response = $this->get(route('locations.index'));

        $response->assertSee(htmlspecialchars($location->name));
    }

    /**
     * Users can view a specific location.
     */
    public function test_a_user_can_view_a_location()
    {
        $this->actingAs($this->user);
        $location = factory('App\Location')->create();

        $response = $this->get(route('locations.show', $location->id));

        $response->assertSee($location->name);
    }

    /**
     * Users cannot create locations.
     */
    public function test_a_user_cannot_store_a_location()
    {
        $this->actingAs($this->user);
        $location = factory('App\Location')->make();

        $response = $this->post(route('locations.store'), $location->toArray());

        $response->assertForbidden();
        $this->assertDatabaseMissing('locations', [
            'name' => $location->name,
            'description' => $location->description,
        ]);
    }

    /**
     * Users cannot update an existing location.
     */
    public function test_a_user_cannot_update_a_location()
    {
        $this->actingAs($this->user);
        $location = factory('App\Location')->create();

        $location->name = 'Updated Name';
        $location->description = 'Updated Description';

        $response = $this->patch(route('locations.update', $location->id), $location->toArray());
        $response->assertForbidden();
        $this->assertNotEquals(1, \App\Location::where([
            ['id', '=', $location->id],
            ['name', '=', $location->name],
            ['description', '=', $location->description],
        ])->count());
    }

    /**
     * Users cannot delete existing locations.
     */
    public function test_a_user_cannot_destroy_a_location()
    {
        $this->actingAs($this->user);

        $location = factory('App\Location')->create();

        $response = $this->delete(route('locations.destroy', $location->id));
        $response->assertForbidden();
        $this->assertDatabaseHas('locations', ['id' => $location->id]);
    }

    /**
     * An admin can create a new location.
     */
    public function test_an_admin_can_store_a_location()
    {
        $this->actingAs($this->admin);
        $location = factory('App\Location')->make();

        $response = $this->post(route('locations.store'), $location->toArray());

        $response->assertRedirect();
        $this->assertDatabaseHas('locations', [
            'name' => $location->name,
            'description' => $location->description,
        ]);
    }

    /**
     * An admin can update an existing location.
     */
    public function test_an_admin_can_update_a_location()
    {
        $this->actingAs($this->admin);
        $location = factory('App\Location')->create();

        $location->name = 'Updated Name';
        $location->description = 'Updated Description';

        $response = $this->patch(route('locations.update', $location->id), $location->toArray());
        $response->assertRedirect();
        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
            'name' => $location->name,
            'description' => $location->description,
        ]);
    }

    /**
     * An admin can delete an existing location.
     */
    public function test_an_admin_can_destroy_a_location()
    {
        $this->actingAs($this->admin);

        $location = factory('App\Location')->create();

        $response = $this->delete(route('locations.destroy', $location->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }
}
