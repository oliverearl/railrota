<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OperationShiftsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test setup
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Gets a shift
     */
    protected function getShift()
    {
        return factory('App\OperationShift');
    }

    /**
     * An operation shift should be able to find its parent operation.
     */
    public function test_an_operation_shift_can_derive_its_parent_operation()
    {
        $this->assertNotNull($this->getShift()->create()->operation);
    }

    /**
     * An operation shift should be able to find its role type.
     */
    public function test_an_operation_shift_can_derive_its_role_type()
    {
        $shift = $this->getShift()->create(['role_type_id' => factory('App\RoleType')->create()->id]);
        $this->assertNotNull($shift->role_type);
    }

    /**
     * An operation shift should be able to find its assigned user.
     */
    public function test_an_operation_shift_can_derive_its_assigned_user_when_it_is_occupied()
    {
        $shift = $this->getShift()->create(['user_id' => factory('App\User')->create()->id]);
        $this->assertNotNull($shift->user);
    }

    /**
     * An operation shift should not be able to find anything when it is unassigned.
     */
    public function test_an_operation_shift_cannot_derive_its_assigned_user_when_it_is_vacant()
    {
        $this->assertNull($this->getShift()->create()->user);
    }

    /**
     * An operation shift should be able to find its role competency.
     */
    public function test_an_operation_shift_can_derive_its_role_competency()
    {
        $shift = $this->getShift()->create(['role_competency_id' => factory('App\RoleCompetency')->create()->id]);
        $this->assertNotNull($shift->role_competency);
    }

    /**
     * An operation shift should not be able to find its role competency when it is unspecified.
     */
    public function test_an_operation_shift_cannot_derive_its_role_competency_when_it_is_unspecified()
    {
        $this->assertNull($this->getShift()->create(['role_competency_id' => null])->role_competency);
    }

    /**
     * An operation shift should be able to find its location.
     */
    public function test_an_operation_shift_can_derive_its_location()
    {
        $shift = $this->getShift()->create(['location_id' => factory('App\Location')->create()->id]);
        $this->assertNotNull($shift->location);
    }

    /**
     * An operation shift should not be able to find its location when it is unspecified.
     */
    public function test_an_operation_shift_cannot_derive_its_location_when_it_is_unspecified()
    {
        $this->assertNull($this->getShift()->create()->location);
    }

    /**
     * An operation shift should be able to find its steam locomotive.
     */
    public function test_an_operation_shift_can_derive_its_steam_locomotive()
    {
        $shift = $this->getShift()->create(['steam_locomotive_id' => factory('App\SteamLocomotive')->create()->id]);
        $this->assertNotNull($shift->steam_locomotive);
    }

    /**
     * An operation shift should not be able to find its powered locomotive when it is unspecified.
     */
    public function test_an_operation_shift_can_not_derive_its_steam_locomotive_when_it_is_unspecified()
    {
        $this->assertNull($this->getShift()->create()->steam_locomotive);
    }

    /**
     * An operation shift should be able to find its powered locomotive.
     */
    public function test_an_operation_shift_can_derive_its_powered_locomotive()
    {
        $shift = $this->getShift()->create(['powered_locomotive_id' => factory('App\PoweredLocomotive')->create()->id]);
        $this->assertNotNull($shift->powered_locomotive);
    }

    /**
     * An operation shift should not be able to find its powered locomotive when it is unspecified.
     */
    public function test_an_operation_shift_can_not_derive_its_powered_locomotive_when_it_is_unspecified()
    {
        $this->assertNull($this->getShift()->create()->powered_locomotive);
    }

    /**
     * This method returns all the data for children of operation shift.
     * This is kinda necessary to build shifts. It's not good and needs refactoring.
     */
    public function test_an_operation_shift_can_get_all_data_pertaining_to_its_children()
    {
        $defaults = $this->getShift()->create()->getData();

        $this->assertIsArray($defaults);
        $this->assertNotEmpty($defaults);
    }
}
