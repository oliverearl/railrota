<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LocationsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Checks whether default locations array is present and is an array.
     */
    public function test_an_array_of_default_locations_can_be_returned()
    {
        $location = factory('App\Location')->create();
        $defaults = $location->getDefaultLocations();

        $this->assertIsArray($defaults);
        $this->assertNotEmpty($defaults);
    }

    /**
     * Check for associated operation shifts
     */
    public function test_a_location_can_retrieve_its_associated_operation_shifts()
    {
        $location = factory('App\Location')->create();

        $this->assertNotNull($location->operation_shifts);
    }
}
