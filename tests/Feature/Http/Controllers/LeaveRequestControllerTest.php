<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LeaveRequestController
 */
final class LeaveRequestControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $leaveRequests = LeaveRequest::factory()->count(3)->create();

        $response = $this->get(route('leave-requests.index'));

        $response->assertOk();
        $response->assertViewIs('leaveRequest.index');
        $response->assertViewHas('leaveRequests');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('leave-requests.create'));

        $response->assertOk();
        $response->assertViewIs('leaveRequest.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LeaveRequestController::class,
            'store',
            \App\Http\Requests\LeaveRequestStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('leave-requests.store'));

        $response->assertRedirect(route('leaveRequests.index'));
        $response->assertSessionHas('leaveRequest.id', $leaveRequest->id);

        $this->assertDatabaseHas(leaveRequests, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $leaveRequest = LeaveRequest::factory()->create();

        $response = $this->get(route('leave-requests.show', $leaveRequest));

        $response->assertOk();
        $response->assertViewIs('leaveRequest.show');
        $response->assertViewHas('leaveRequest');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $leaveRequest = LeaveRequest::factory()->create();

        $response = $this->get(route('leave-requests.edit', $leaveRequest));

        $response->assertOk();
        $response->assertViewIs('leaveRequest.edit');
        $response->assertViewHas('leaveRequest');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LeaveRequestController::class,
            'update',
            \App\Http\Requests\LeaveRequestUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $leaveRequest = LeaveRequest::factory()->create();

        $response = $this->put(route('leave-requests.update', $leaveRequest));

        $leaveRequest->refresh();

        $response->assertRedirect(route('leaveRequests.index'));
        $response->assertSessionHas('leaveRequest.id', $leaveRequest->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $leaveRequest = LeaveRequest::factory()->create();

        $response = $this->delete(route('leave-requests.destroy', $leaveRequest));

        $response->assertRedirect(route('leaveRequests.index'));

        $this->assertSoftDeleted($leaveRequest);
    }
}
