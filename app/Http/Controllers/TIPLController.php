<?php

namespace App\Http\Controllers;

use App\Http\Requests\TIPLStoreRequest;
use App\Http\Requests\TIPLUpdateRequest;
use App\Models\TIPL;
use App\Models\TqUser;
use App\Models\UnsuccessfulRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TIPLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Allow all authenticated users to view the list
        $tipls = TIPL::orderBy('created_at', 'desc')->paginate(20);
        
        // Calculate pick up point statistics
        $pickUpPointStats = TIPL::selectRaw('COALESCE(pick_up_point, "Not Specified") as pick_up_point, COUNT(*) as count')
            ->groupBy('pick_up_point')
            ->orderByRaw('CASE WHEN pick_up_point IS NULL THEN 1 ELSE 0 END, pick_up_point')
            ->get();
        
        // Get total count
        $totalEntries = TIPL::count();
        
        // Get unsuccessful registrations (only for admins)
        $unsuccessfulRegistrations = [];
        if (auth()->user() && auth()->user()->isAdmin) {
            $unsuccessfulRegistrations = UnsuccessfulRegistration::orderBy('created_at', 'desc')->get();
        }
        
        return view('tipl.index', [
            'tipls' => $tipls,
            'pickUpPointStats' => $pickUpPointStats,
            'totalEntries' => $totalEntries,
            'unsuccessfulRegistrations' => $unsuccessfulRegistrations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Calculate total seats used (1 seat per entry + expected_guests for each entry)
        $totalSeatsUsed = (int) (TIPL::selectRaw('SUM(1 + COALESCE(expected_guests, 0)) as total')->value('total') ?? 0);
        $maxSeats = 230;
        $totalEntries = TIPL::count();

        // If accessed from root route, return welcome view, otherwise return tipl.create
        if (request()->routeIs('welcome')) {
            return view('welcome', [
                'totalEntries' => $totalEntries,
                'totalSeatsUsed' => $totalSeatsUsed,
                'maxSeats' => $maxSeats,
            ]);
        }

        return view('tipl.create', [
            'totalEntries' => $totalEntries,
            'totalSeatsUsed' => $totalSeatsUsed,
            'maxSeats' => $maxSeats,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TIPLStoreRequest $request): RedirectResponse
    {
        // Calculate total seats used (1 seat per entry + expected_guests for each entry)
        $totalSeatsUsed = (int) (TIPL::selectRaw('SUM(1 + COALESCE(expected_guests, 0)) as total')->value('total') ?? 0);
        $maxSeats = 230;
        $expectedGuests = (int)($request->input('expected_guests', 0));
        $seatsNeeded = 1 + $expectedGuests; // 1 for the user + expected guests
        
        if ($totalSeatsUsed + $seatsNeeded > $maxSeats) {
            $seatsLeft = max(0, $maxSeats - $totalSeatsUsed);
            return redirect()->route('welcome')
                ->with('error', "Sorry. Only {$seatsLeft} seat(s) remaining, cannot accomodate {$seatsNeeded} seat(s).");
        }

        $validated = $request->validated();
        // Remove tq_user_id as it's only for validation, not a database column
        unset($validated['tq_user_id']);
        
        $tipl = TIPL::create($validated);

        // For public submissions, redirect back to welcome page with success message
        if (!auth()->check()) {
            return redirect()->route('welcome')
                ->with('success', 'Thank you! Your registration has been submitted successfully.');
        }

        // For authenticated users, redirect to index
        return redirect()->route('tipl.index')->with('success', 'TIPL entry created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, TIPL $tipl): View
    {
        // Allow all authenticated users to view details
        return view('tipl.show', [
            'tipl' => $tipl,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, TIPL $tipl): View
    {
        // Only allow admin users to edit
        if (!auth()->user() || !auth()->user()->isAdmin) {
            abort(403, 'Unauthorized action. Only administrators can edit TIPL entries.');
        }

        return view('tipl.edit', [
            'tipl' => $tipl,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TIPLUpdateRequest $request, TIPL $tipl): RedirectResponse
    {
        // Only allow admin users to update
        if (!auth()->user() || !auth()->user()->isAdmin) {
            abort(403, 'Unauthorized action. Only administrators can update TIPL entries.');
        }

        $tipl->update($request->validated());

        $request->session()->flash('tipl.id', $tipl->id);

        return redirect()->route('tipl.index')->with('success', 'TIPL entry updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TIPL $tipl): RedirectResponse
    {
        // Only allow admin users to delete
        if (!auth()->user() || !auth()->user()->isAdmin) {
            abort(403, 'Unauthorized action. Only administrators can delete TIPL entries.');
        }

        $tipl->delete();

        return redirect()->route('tipl.index')->with('success', 'TIPL entry deleted successfully');
    }

    /**
     * Verify if the provided ID exists in tqUsers table.
     */
    public function verifyId(Request $request): JsonResponse
    {
        $request->validate([
            'id_code' => 'required|string',
        ]);

        $tqUser = TqUser::where('id_code', $request->id_code)->first();

        if (!$tqUser) {
            return response()->json([
                'valid' => false,
                'message' => 'ID not found. Please enter a valid ID.',
            ], 404);
        }

        // Check for duplicate TIPL entry with this employee_id
        $existingEntry = TIPL::where('employee_id', $tqUser->id_code)->first();

        if ($existingEntry) {
            return response()->json([
                'valid' => false,
                'duplicate' => true,
                'message' => 'You have already registered.',
            ], 409);
        }

        // Check if registration is closed
        $totalSeatsUsed = (int) (TIPL::selectRaw('SUM(1 + COALESCE(expected_guests, 0)) as total')->value('total') ?? 0);
        $maxSeats = 230;
        $isRegistrationClosed = $totalSeatsUsed >= $maxSeats;

        if ($isRegistrationClosed) {
            // Insert into unsuccessful_registration table
            \App\Models\UnsuccessfulRegistration::create([
                'id_code' => $tqUser->id_code,
                'name' => $tqUser->name,
                'company_name' => $tqUser->company_name ?? null,
            ]);

            return response()->json([
                'valid' => false,
                'registration_closed' => true,
                'message' => 'Registration is closed. We have reached the maximum limit of available seats. Thank you for your interest!',
            ], 410); // 410 Gone status code
        }

        return response()->json([
            'valid' => true,
            'name' => $tqUser->name,
            'employee_id' => $tqUser->id_code,
            'company_name' => $tqUser->company_name ?? '',
            'message' => 'ID verified successfully.',
        ]);
    }

    /**
     * Export TIPL entries to Excel (CSV format).
     */
    public function export(Request $request): StreamedResponse
    {
        $filename = 'tipl_export_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Add headers
            fputcsv($file, [
                'ID',
                'Name',
                'Employee ID',
                'Company Name',
                'Phone Number',
                'Expected Guests',
                'Pick Up Point',
                'In-House Talent',
                'Created At',
                'Updated At',
            ]);

            // Get all TIPL entries
            $tipls = TIPL::select([
                'id',
                'name',
                'employee_id',
                'company_name',
                'phone_number',
                'expected_guests',
                'pick_up_point',
                'in_house_talent',
                'created_at',
                'updated_at',
            ])->get();

            // Add TIPL data
            foreach ($tipls as $tipl) {
                fputcsv($file, [
                    $tipl->id,
                    $tipl->name,
                    $tipl->employee_id ?? '',
                    $tipl->company_name ?? '',
                    $tipl->phone_number ?? '',
                    $tipl->expected_guests ?? '',
                    $tipl->pick_up_point ?? '',
                    $tipl->in_house_talent ?? '',
                    $tipl->created_at ? $tipl->created_at->format('Y-m-d H:i:s') : '',
                    $tipl->updated_at ? $tipl->updated_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
