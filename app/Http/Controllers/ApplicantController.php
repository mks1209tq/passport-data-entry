<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicantStoreRequest;
use App\Http\Requests\ApplicantUpdateRequest;
use App\Models\Applicant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendApplicantDataToUI;
use Illuminate\Support\Facades\Log;


class ApplicantController extends Controller
{
    public function index(Request $request): View
    {
        $applicants = Applicant::all();

        return view('applicant.index', compact('applicants'));
    }

    public function create(Request $request): View
    {
        return view('applicant.create');
    }

    public function store(ApplicantStoreRequest $request): RedirectResponse
    {
        $applicant = Applicant::create($request->validated());

        $request->session()->flash('applicant.id', $applicant->id);

        return redirect()->route('applicants.index');
    }

    public function show(Request $request, Applicant $applicant): View
    {
        return view('applicant.show', compact('applicant'));
    }

    public function edit(Request $request, Applicant $applicant): View
    {
        return view('applicant.edit', compact('applicant'));
    }

    public function update(ApplicantUpdateRequest $request, Applicant $applicant): RedirectResponse
    {
        $applicant->update($request->validated());

        $request->session()->flash('applicant.id', $applicant->id);

        return redirect()->route('applicants.index');
    }

    public function destroy(Request $request, Applicant $applicant): RedirectResponse
    {
        $applicant->delete();

        return redirect()->route('applicants.index');
    }

    
    public function showSend()
    {
        return view('applicant.show-send');
    }
    
    // public function send()
    // {
    //     try {
    //         $applicants = Applicant::all()
    //         ->toArray();

    //     $response = Http::post('https://ui.test/api/receive-applicant', [
    //         'applicants' => $applicants,
    //         'total_count' => count($applicants),
    //         'sent_at' => now()->toDateTimeString()
    //     ]);


    //     // Debug the response
    //     dd([
    //         'status' => $response->status(),
    //         'body' => $response->body(),  // This will show the error message from UI
    //         'sent_data' => [
    //             'count' => count($applicants),
    //             'first_record' => array_slice($applicants, 0, 1)
    //         ]
    //     ]);

    //     if ($response->successful()) {
    //         return redirect()->route('applicants.send')
    //             ->with('success', 'Successfully sent ' . count($applicants) . ' records to UI system.');
    //     }

    //     return redirect()->route('applicants.send')
    //         ->with('error', 'Failed to send data. Status: ' . $response->status());

    //     } catch (\Exception $e) {
    //     return redirect()->route('applicants.send')
    //         ->with('error', 'Error: ' . $e->getMessage());
    //     }
    // }

    public function send()
    {
        try {
            $applicantIds = Applicant::pluck('id')->values()->toArray();
            
            if (empty($applicantIds)) {
                return redirect()->route('applicants.show-send')
                    ->with('error', 'No applicants found to send.');
            }
    
            // Debug log
            Log::info('Dispatching job with IDs', ['ids' => $applicantIds]);
    
            SendApplicantDataToUI::dispatch($applicantIds)
                ->onQueue('applicant-sync');
    
            return redirect()->route('applicants.show-send')
                ->with('success', count($applicantIds) . ' records queued for processing.');
    
        } catch (\Exception $e) {
            Log::error('Error queuing applicant data: ' . $e->getMessage());
            return redirect()->route('applicants.show-send')
                ->with('error', 'Error queuing data: ' . $e->getMessage());
        }
    }
}
