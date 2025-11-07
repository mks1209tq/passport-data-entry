<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\eventController
 */
final class eventControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $events = event::factory()->count(3)->create();

        $response = $this->get(route('events.index'));

        $response->assertOk();
        $response->assertViewIs('event.index');
        $response->assertViewHas('events');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('events.create'));

        $response->assertOk();
        $response->assertViewIs('event.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\eventController::class,
            'store',
            \App\Http\Requests\eventStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('events.store'));

        $response->assertRedirect(route('events.index'));
        $response->assertSessionHas('event.id', $event->id);

        $this->assertDatabaseHas(events, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $event = event::factory()->create();

        $response = $this->get(route('events.show', $event));

        $response->assertOk();
        $response->assertViewIs('event.show');
        $response->assertViewHas('event');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $event = event::factory()->create();

        $response = $this->get(route('events.edit', $event));

        $response->assertOk();
        $response->assertViewIs('event.edit');
        $response->assertViewHas('event');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\eventController::class,
            'update',
            \App\Http\Requests\eventUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $event = event::factory()->create();

        $response = $this->put(route('events.update', $event));

        $event->refresh();

        $response->assertRedirect(route('events.index'));
        $response->assertSessionHas('event.id', $event->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $event = event::factory()->create();
        $event = Event::factory()->create();

        $response = $this->delete(route('events.destroy', $event));

        $response->assertRedirect(route('events.index'));

        $this->assertModelMissing($event);
    }
}
