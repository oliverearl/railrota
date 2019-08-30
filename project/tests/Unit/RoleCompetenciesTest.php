<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RoleCompetenciesTest extends TestCase
{
    use DatabaseMigrations;

    protected $roleCompetency;

    /**
     * Test setup
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->roleCompetency = factory('App\RoleCompetency')->create();
    }

    /**
     * Checks to ensure that a parent role type of a competency can be successfully retrieved
     */
    public function test_a_role_type_can_be_derived_from_a_role_competency()
    {
        $this->assertIsInt($this->roleCompetency->role_type->id);
        $this->assertInstanceOf(\App\RoleType::class, $this->roleCompetency->role_type);
    }

    /**
     * The tier must be an integer between 1 and 10
     */
    public function test_a_role_competency_has_a_corresponding_tier_between_one_and_ten()
    {
        $this->assertIsInt($this->roleCompetency->tier);
        $this->assertThat($this->roleCompetency->tier, $this->logicalAnd(
            $this->GreaterThanOrEqual(1),
            $this->lessThanOrEqual(10)
        ));
    }

    /**
     * Controller Defaults Check
     */
    public function test_an_array_of_default_role_competencies_for_a_controller_can_be_returned()
    {
        $defaults = $this->roleCompetency->getControllerDefaults();

        $this->assertIsArray($defaults);
        $this->assertNotEmpty($defaults);
    }

    /**
     * Guard Defaults Check
     */
    public function test_an_array_of_default_role_competencies_for_a_guard_can_be_returned()
    {
        $defaults = $this->roleCompetency->getGuardDefaults();

        $this->assertIsArray($defaults);
        $this->assertNotEmpty($defaults);
    }

    /**
     * Blockman Defaults Check
     */
    public function test_an_array_of_default_role_competencies_for_a_blockman_can_be_returned()
    {
        $defaults = $this->roleCompetency->getBlockmanDefaults();

        $this->assertIsArray($defaults);
        $this->assertNotEmpty($defaults);
    }

    /**
     * Powered Locomotive Defaults Check
     */
    public function test_an_array_of_default_role_competencies_for_a_powered_locomotive_can_be_returned()
    {
        $defaults = $this->roleCompetency->getPoweredDefaults();

        $this->assertIsArray($defaults);
        $this->assertNotEmpty($defaults);
    }

    /**
     * Steam Locomotive Defaults Check
     */
    public function test_an_array_of_default_role_competencies_for_a_steam_locomotive_can_be_returned()
    {
        $defaults = $this->roleCompetency->getSteamDefaults();

        $this->assertIsArray($defaults);
        $this->assertNotEmpty($defaults);
    }

    /**
     * Check for associated operation shifts
     */
    public function test_a_role_competency_can_retrieve_its_associated_operation_shifts()
    {
        $this->assertNotNull($this->roleCompetency->operation_shifts);
    }
}
