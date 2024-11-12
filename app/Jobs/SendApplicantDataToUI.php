<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Applicant;

class SendApplicantDataToUI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $applicantIds;

    public function __construct(array $applicantIds)
    {
        $this->applicantIds = array_values(array_filter($applicantIds, 'is_numeric'));
    }

    public function handle(): void
    {
        try {
            // Log::info('Starting SendApplicantDataToUI job', [
            //     'ids_count' => count($this->applicantIds)
            // ]);

            // Fetch applicants using the IDs
            $applicants = Applicant::whereIn('id', $this->applicantIds)->get();

            if ($applicants->isEmpty()) {
                Log::warning('No applicants found for the given IDs', [
                    'ids' => $this->applicantIds
                ]);
                return;
            }

            // Transform to array format needed by UI
            $data = [
                'applicants' => $applicants->map(function ($applicant) {
                    return [
                        'id' => $applicant->id,
                        'name' => $applicant->name,
                        'email' => $applicant->email,
                        'created_at' => $applicant->created_at,
                        'updated_at' => $applicant->updated_at,
                        // Add other fields as needed
                    ];
                })->toArray(),
                'total_count' => $applicants->count(),
                'sent_at' => now()->format('Y-m-d H:i:s')
            ];

            Log::info('Sending data to UI', [
                'count' => $applicants->count(),
                'sample' => array_slice($data['applicants'], 0, 1) // Log first record
            ]);

            $response = Http::post('https://ui.test/api/data/receive', $data);

            if ($response->successful()) {
                Log::info('Successfully sent applicants to UI', [
                    'count' => $applicants->count(),
                    'response' => $response->json()
                ]);
                return;
            }

            throw new \Exception('Failed to send data: ' . $response->body());

        } catch (\Exception $e) {
            Log::error('Error in SendApplicantDataToUI job', [
                'error' => $e->getMessage(),
                'ids' => $this->applicantIds
            ]);
            
            throw $e;
        }
    }
}