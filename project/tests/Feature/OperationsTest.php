<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OperationsTest extends TestCase
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
     * Helper function for using Carbon to format dates in long form
     * @param $date
     * @return string
     */
    protected function formatDate($date)
    {
        return Carbon::parse($date)->toFormattedDateString();
    }

    /**
     * Helper function for using Carbon to format dates in short form
     * @param $date
     * @return string
     */
    protected function formatDateShort($date)
    {
        return Carbon::parse($date)->format('d/m/y');
    }

    /**
     * Guests cannot view operations.
     */
    public function test_a_guest_cannot_view_operations()
    {
        $response = $this->get(route('operations.index'));

        $response->assertRedirect(route('login'));
        $response->assertSee('login');
    }

    /**
     * Users can view operations.
     */
    public function test_a_user_can_view_operations()
    {
        $this->actingAs($this->user);
        $operation = factory('App\Operation')->create();

        $response = $this->get(route('operations.index'));

        $response->assertSee($this->formatDate($operation->date));
    }

    /**
     * Users can view individual operations. In great detail, I might add.
     */
    public function test_a_user_can_view_an_operation()
    {
        $this->actingAs($this->user);
        $operation = factory('App\Operation')->create();

        $response = $this->get(route('operations.show', $operation->id));

        $response->assertSee($this->formatDate($operation->date));
    }

    /**
     * Users can view all operations in a special, last-minute addition, the
     * calendar view. It was hotly requested, so it's important that it works.
     */
    public function test_a_user_can_view_operations_in_the_calendar()
    {
        $this->actingAs($this->user);
        $operation = factory('App\Operation')->create();

        $response = $this->get(route('operations.calendar'));
        $response->assertSee($this->formatDateShort($operation->date));
    }

    /**
     * The ability to export the calendar view to a PDF document is important
     * for the running of the railway. This will check that it does just that.
     */
    public function test_a_user_can_export_operations_to_pdf_download()
    {
        $this->actingAs($this->user);
        factory('App\Operation')->create();

        $response = $this->get(route('operations.pdf'));
        $response->assertHeader('content-type', 'application/pdf');
    }

    /**
     * Users cannot create their own operations.
     * This is not the same as registering to a shift.
     */
    public function test_a_user_cannot_store_an_operation()
    {
        $this->actingAs($this->user);
        $operation = factory('App\Operation')->make();


        $response = $this->post(route('operations.store'), $operation->toArray());

        $response->assertForbidden();
        $this->assertDatabaseMissing('operations', [
            'is_running' => $operation->is_running,
            'description' => $operation->description,
        ]);
    }

    /**
     * Users may not edit or modify an operation.
     */
    public function test_a_user_cannot_update_an_operation()
    {
        $this->actingAs($this->user);
        $operation = factory('App\Operation')->create();

        $operation->description = 'New Description';

        $response = $this->patch(route('operations.update', $operation->id), $operation->toArray());
        $response->assertForbidden();
        $this->assertNotEquals(1, \App\Operation::where([
            ['id', '=', $operation->id],
            ['description', '=', $operation->description],
        ])->count());
    }

    /**
     * Users may not delete operations. For obvious reasons.
     */
    public function test_a_user_cannot_destroy_an_operation()
    {
        $this->actingAs($this->user);

        $operation = factory('App\Operation')->create();

        $response = $this->delete(route('operations.destroy', $operation->id));
        $response->assertForbidden();
        $this->assertDatabaseHas('operations', ['id' => $operation->id]);
    }

    /**
     * Admins can create operations.
     */
    public function test_an_admin_can_store_an_operation()
    {
        $this->actingAs($this->admin);
        $operation = factory('App\Operation')->make();

        $response = $this->post(route('operations.store'), $operation->toArray());

        $response->assertRedirect();
        $this->assertDatabaseHas('operations', [
            'is_running' => $operation->is_running,
            'notes' => $operation->notes,
        ]);
    }

    /**
     * Admins can edit existing operations.
     */
    public function test_an_admin_can_update_an_operation()
    {
        $this->actingAs($this->admin);
        $operation = factory('App\Operation')->create();

        $operation->description = 'New Description';

        $response = $this->patch(route('operations.update', $operation->id), $operation->toArray());
        $response->assertRedirect();
        $this->assertDatabaseHas('operations', [
            'id' => $operation->id,
            'notes' => $operation->notes,
        ]);
    }

    /**
     * Admins can delete existing operations.
     */
    public function test_an_admin_can_destroy_an_operation()
    {
        $this->actingAs($this->admin);

        $operation = factory('App\Operation')->create();

        $response = $this->delete(route('operations.destroy', $operation->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('operations', ['id' => $operation->id]);
    }
}
