<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RoleTypesTest extends TestCase

{
    use DatabaseMigrations;

    /**
     * Checks whether default user array is present and is an array.
     */
    public function test_an_array_of_default_role_types_can_be_returned()
    {
        $roleType = factory('App\RoleType')->create();
        $defaults = $roleType->getDefaultTypes();

        $this->assertIsArray($defaults);
        $this->assertNotEmpty($defaults);
    }
}
