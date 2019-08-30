<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SteamLocomotivesTest extends TestCase
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
     * Guests cannot view steam locomotives.
     */
    public function test_a_guest_cannot_view_steam_locomotives()
    {
        $response = $this->get(route('steam_locomotives.index'));

        $response->assertRedirect(route('login'));
        $response->assertSee('login');
    }

    /**
     * Users can view all steam locomotives.
     */
    public function test_a_user_can_view_all_steam_locomotives()
    {
        $this->actingAs($this->user);
        $locomotive = factory('App\SteamLocomotive')->create();

        $response = $this->get(route('steam_locomotives.index'));

        $response->assertSee(htmlspecialchars($locomotive->name));
    }

    /**
     * Users can view a specific steam locomotive.
     */
    public function test_a_user_can_view_a_steam_locomotive()
    {
        $this->actingAs($this->user);
        $locomotive = factory('App\SteamLocomotive')->create();

        $response = $this->get(route('steam_locomotives.show', $locomotive->id));

        $response->assertSee($locomotive->name);
    }

    /**
     * Users cannot create steam locomotives.
     */
    public function test_a_user_cannot_store_a_steam_locomotive()
    {
        $this->actingAs($this->user);
        $locomotive = factory('App\SteamLocomotive')->make();

        $response = $this->post(route('steam_locomotives.store'), $locomotive->toArray());

        $response->assertForbidden();
        $this->assertDatabaseMissing('steam_locomotives', [
            'name' => $locomotive->name,
            'description' => $locomotive->description,
        ]);
    }

    /**
     * Users cannot update an existing steam locomotive.
     */
    public function test_a_user_cannot_update_a_steam_locomotive()
    {
        $this->actingAs($this->user);
        $locomotive = factory('App\SteamLocomotive')->create();

        $locomotive->name = 'Updated Name';
        $locomotive->description = 'Updated Description';

        $response = $this->patch(route('steam_locomotives.update', $locomotive->id), $locomotive->toArray());
        $response->assertForbidden();
        $this->assertNotEquals(1, \App\SteamLocomotive::where([
            ['id', '=', $locomotive->id],
            ['name', '=', $locomotive->name],
            ['description', '=', $locomotive->description],
        ])->count());
    }

    /**
     * Users cannot delete existing steam locomotives.
     */
    public function test_a_user_cannot_destroy_a_steam_locomotive()
    {
        $this->actingAs($this->user);

        $locomotive = factory('App\SteamLocomotive')->create();

        $response = $this->delete(route('steam_locomotives.destroy', $locomotive->id));
        $response->assertForbidden();
        $this->assertDatabaseHas('steam_locomotives', ['id' => $locomotive->id]);
    }

    /**
     * An admin can create a new steam locomotive.
     */
    public function test_an_admin_can_store_a_steam_locomotive()
    {
        $this->actingAs($this->admin);
        $locomotive = factory('App\SteamLocomotive')->make();

        $response = $this->post(route('steam_locomotives.store'), $locomotive->toArray());

        $response->assertRedirect();
        $this->assertDatabaseHas('steam_locomotives', [
            'name' => $locomotive->name,
            'description' => $locomotive->description,
        ]);
    }

    /**
     * An admin can update an existing steam locomotive.
     */
    public function test_an_admin_can_update_a_steam_locomotive()
    {
        $this->actingAs($this->admin);
        $locomotive = factory('App\SteamLocomotive')->create();

        $locomotive->name = 'Updated Name';
        $locomotive->description = 'Updated Description';

        $response = $this->patch(route('steam_locomotives.update', $locomotive->id), $locomotive->toArray());
        $response->assertRedirect();
        $this->assertDatabaseHas('steam_locomotives', [
            'id' => $locomotive->id,
            'name' => $locomotive->name,
            'description' => $locomotive->description,
        ]);
    }

    /**
     * An admin can delete an existing steam locomotive.
     */
    public function test_an_admin_can_destroy_a_steam_locomotive()
    {
        $this->actingAs($this->admin);

        $locomotive = factory('App\SteamLocomotive')->create();

        $response = $this->delete(route('steam_locomotives.destroy', $locomotive->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('steam_locomotives', ['id' => $locomotive->id]);
    }
}
