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

    /**
     * Operation can retrieve its children shifts
     */
    public function test_an_operation_can_retrieve_its_associated_operation_shifts()
    {
        $this->actingAs($this->user);
        $operation = factory('App\Operation')->create();

        $this->assertNotNull($operation->operation_shifts);
    }

    /**
     * Test to see whether a PDF file is created in storage when the calendar is exported using the PDF route
     */
    public function test_an_operation_creates_a_pdf_file_in_laravel_storage_when_the_calendar_view_is_exported()
    {
        $this->actingAs($this->user);
        $this->get(route('operations.pdf'));
        $filename = Carbon::now()->format('ymd') . '_operations.pdf';

        $this->assertTrue(file_exists(storage_path() . '/' . $filename));
    }
}
