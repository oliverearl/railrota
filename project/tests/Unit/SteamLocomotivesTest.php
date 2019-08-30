<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SteamLocomotivesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Checks whether default steam locomotives array is present and is an array.
     */
    public function test_an_array_of_default_steam_locomotives_can_be_returned()
    {
        $locomotive = factory('App\SteamLocomotive')->create();
        $defaults = $locomotive->getDefaultLocomotives();

        $this->assertIsArray($defaults);
        $this->assertNotEmpty($defaults);
    }
}
