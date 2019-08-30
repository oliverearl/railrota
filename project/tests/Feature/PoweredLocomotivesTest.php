<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PoweredLocomotivesTest extends TestCase
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
     * Guests cannot view powered locomotives.
     */
    public function test_a_guest_cannot_view_powered_locomotives()
    {
        $response = $this->get(route('powered_locomotives.index'));

        $response->assertRedirect(route('login'));
        $response->assertSee('login');
    }

    /**
     * Users can view all powered locomotives.
     */
    public function test_a_user_can_view_all_powered_locomotives()
    {
        $this->actingAs($this->user);
        $locomotive = factory('App\PoweredLocomotive')->create();

        $response = $this->get(route('powered_locomotives.index'));

        $response->assertSee(htmlspecialchars($locomotive->name));
    }

    /**
     * Users can view a specific powered locomotive.
     */
    public function test_a_user_can_view_a_powered_locomotive()
    {
        $this->actingAs($this->user);
        $locomotive = factory('App\PoweredLocomotive')->create();

        $response = $this->get(route('powered_locomotives.show', $locomotive->id));

        $response->assertSee($locomotive->name);
    }

    /**
     * Users cannot create powered locomotives.
     */
    public function test_a_user_cannot_store_a_powered_locomotive()
    {
        $this->actingAs($this->user);
        $locomotive = factory('App\PoweredLocomotive')->make();

        $response = $this->post(route('powered_locomotives.store'), $locomotive->toArray());

        $response->assertForbidden();
        $this->assertDatabaseMissing('powered_locomotives', [
            'name' => $locomotive->name,
            'description' => $locomotive->description,
        ]);
    }

    /**
     * Users cannot update an existing powered locomotive.
     */
    public function test_a_user_cannot_update_a_powered_locomotive()
    {
        $this->actingAs($this->user);
        $locomotive = factory('App\PoweredLocomotive')->create();

        $locomotive->name = 'Updated Name';
        $locomotive->description = 'Updated Description';

        $response = $this->patch(route('powered_locomotives.update', $locomotive->id), $locomotive->toArray());
        $response->assertForbidden();
        $this->assertNotEquals(1, \App\PoweredLocomotive::where([
            ['id', '=', $locomotive->id],
            ['name', '=', $locomotive->name],
            ['description', '=', $locomotive->description],
        ])->count());
    }

    /**
     * Users cannot delete existing powered locomotives.
     */
    public function test_a_user_cannot_destroy_a_powered_locomotive()
    {
        $this->actingAs($this->user);

        $locomotive = factory('App\PoweredLocomotive')->create();

        $response = $this->delete(route('powered_locomotives.destroy', $locomotive->id));
        $response->assertForbidden();
        $this->assertDatabaseHas('powered_locomotives', ['id' => $locomotive->id]);
    }

    /**
     * An admin can create a new powered locomotive.
     */
    public function test_an_admin_can_store_a_powered_locomotive()
    {
        $this->actingAs($this->admin);
        $locomotive = factory('App\PoweredLocomotive')->make();

        $response = $this->post(route('powered_locomotives.store'), $locomotive->toArray());

        $response->assertRedirect();
        $this->assertDatabaseHas('powered_locomotives', [
            'name' => $locomotive->name,
            'description' => $locomotive->description,
        ]);
    }

    /**
     * An admin can update an existing powered locomotive.
     */
    public function test_an_admin_can_update_a_powered_locomotive()
    {
        $this->actingAs($this->admin);
        $locomotive = factory('App\PoweredLocomotive')->create();

        $locomotive->name = 'Updated Name';
        $locomotive->description = 'Updated Description';

        $response = $this->patch(route('powered_locomotives.update', $locomotive->id), $locomotive->toArray());
        $response->assertRedirect();
        $this->assertDatabaseHas('powered_locomotives', [
            'id' => $locomotive->id,
            'name' => $locomotive->name,
            'description' => $locomotive->description,
        ]);
    }

    /**
     * An admin can delete an existing powered locomotive.
     */
    public function test_an_admin_can_destroy_a_powered_locomotive()
    {
        $this->actingAs($this->admin);

        $locomotive = factory('App\PoweredLocomotive')->create();

        $response = $this->delete(route('powered_locomotives.destroy', $locomotive->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('powered_locomotives', ['id' => $locomotive->id]);
    }
}
