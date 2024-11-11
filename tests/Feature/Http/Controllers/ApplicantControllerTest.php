<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ApplicantController
 */
final class ApplicantControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $applicants = Applicant::factory()->count(3)->create();

        $response = $this->get(route('applicants.index'));

        $response->assertOk();
        $response->assertViewIs('applicant.index');
        $response->assertViewHas('applicants');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('applicants.create'));

        $response->assertOk();
        $response->assertViewIs('applicant.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ApplicantController::class,
            'store',
            \App\Http\Requests\ApplicantStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('applicants.store'));

        $response->assertRedirect(route('applicants.index'));
        $response->assertSessionHas('applicant.id', $applicant->id);

        $this->assertDatabaseHas(applicants, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $applicant = Applicant::factory()->create();

        $response = $this->get(route('applicants.show', $applicant));

        $response->assertOk();
        $response->assertViewIs('applicant.show');
        $response->assertViewHas('applicant');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $applicant = Applicant::factory()->create();

        $response = $this->get(route('applicants.edit', $applicant));

        $response->assertOk();
        $response->assertViewIs('applicant.edit');
        $response->assertViewHas('applicant');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ApplicantController::class,
            'update',
            \App\Http\Requests\ApplicantUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $applicant = Applicant::factory()->create();

        $response = $this->put(route('applicants.update', $applicant));

        $applicant->refresh();

        $response->assertRedirect(route('applicants.index'));
        $response->assertSessionHas('applicant.id', $applicant->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $applicant = Applicant::factory()->create();

        $response = $this->delete(route('applicants.destroy', $applicant));

        $response->assertRedirect(route('applicants.index'));

        $this->assertSoftDeleted($applicant);
    }
}
