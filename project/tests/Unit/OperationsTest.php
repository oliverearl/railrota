<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OperationsTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    /**
     * Test setup
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
    }

    public function test_an_operation_can_retrieve_its_associated_operation_shifts()
    {
        $this->actingAs($this->user);
        $operation = factory('App\Operation')->create();

        $this->assertNotNull($operation->operation_shifts);
    }
}
