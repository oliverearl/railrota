<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RolesTest extends TestCase
{
    use DatabaseMigrations;

    protected $role;

    /**
     * Test setup
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->role = factory('App\Role')->create();
    }

    /**
     * Checks to ensure that a parent role type of a role can be successfully retrieved
     */
    public function test_a_role_type_can_be_derived_from_a_role()
    {
        $this->assertIsInt($this->role->role_type->id);
        $this->assertInstanceOf(\App\RoleType::class, $this->role->role_type);
    }

    /**
     * Checks to ensure that a parent user of a role can be successfully retrieved
     */
    public function test_a_user_can_be_derived_from_a_role()
    {
        $this->assertIsInt($this->role->user->id);
        $this->assertInstanceOf(\App\User::class, $this->role->user);
    }

    /**
     * Checks to ensure that a parent user of a role can be successfully retrieved
     */
    public function test_a_role_competency_can_be_derived_from_a_role()
    {
        $this->assertIsInt($this->role->role_competency->id);
        $this->assertInstanceOf(\App\RoleCompetency::class, $this->role->role_competency);
    }

    /**
     * Checks that roles can be created without the use of a competency
     */
    public function test_a_role_can_also_have_a_null_value_when_no_competency_is_set()
    {
        $apatheticRole = factory('App\Role')->create(['role_competency_id' => null]);

        $this->assertNull($apatheticRole->role_competency_id);
    }
}
