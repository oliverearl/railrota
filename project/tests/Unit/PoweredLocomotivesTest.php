<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PoweredLocomotivesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Checks whether default powered locomotives array is present and is an array.
     */
    public function test_an_array_of_default_powered_locomotives_can_be_returned()
    {
        $locomotive = factory('App\PoweredLocomotive')->create();
        $defaults = $locomotive->getDefaultLocomotives();

        $this->assertIsArray($defaults);
        $this->assertNotEmpty($defaults);
    }
}
