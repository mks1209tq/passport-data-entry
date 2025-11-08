<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestStoreRequest;
use App\Http\Requests\GuestUpdateRequest;
use App\Models\Guest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = trim($request->input('q', ''));
        
        // Eager load all guests data into memory for faster search
        $allGuests = Guest::select([
            'id',
            'name',
            'designation',
            'company',
            'category',
            'proposalBy',
            'guestOf',
            'RSVP',
            'tableAllocation',
            'attendance',
        ])->get();
        
        $guests = $allGuests;

        if (!empty($query)) {
            $searchTerm = strtolower($query);
            
            // Filter guests in memory using collection methods for faster search
            $guests = $allGuests->filter(function ($guest) use ($searchTerm) {
                return str_contains(strtolower($guest->name ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->designation ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->company ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->category ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->proposalBy ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->guestOf ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->RSVP ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->tableAllocation ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->attendance ?? ''), $searchTerm);
            })->values();
        }

        return view('guest.index', [
            'guests' => $guests,
            'searchQuery' => $query,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        return view('guest.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuestStoreRequest $request): RedirectResponse
    {
        $guest = Guest::create($request->validated());

        $request->session()->flash('guest.id', $guest->id);

        return redirect()->route('guests.index')->with('success', 'Guest created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Guest $guest): View
    {
        return view('guest.show', [
            'guest' => $guest,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Guest $guest): View
    {
        return view('guest.edit', [
            'guest' => $guest,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuestUpdateRequest $request, Guest $guest): RedirectResponse
    {
        $guest->update($request->validated());

        $request->session()->flash('guest.id', $guest->id);

        return redirect()->route('guests.index')->with('success', 'Guest updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Guest $guest): RedirectResponse
    {
        // Only allow admins to delete guests
        if (!auth()->user()->isAdmin) {
            abort(403, 'Unauthorized action. Only administrators can delete guests.');
        }

        $guest->delete();

        return redirect()->route('guests.index')->with('success', 'Guest deleted successfully');
    }

    /**
     * Search guests.
     */
    public function search(Request $request): View
    {
        $query = trim($request->input('q', ''));
        
        // Eager load all guests data into memory for faster search
        $allGuests = Guest::select([
            'id',
            'name',
            'designation',
            'company',
            'category',
            'proposalBy',
            'guestOf',
            'RSVP',
            'tableAllocation',
            'attendance',
        ])->get();
        
        $guests = collect();

        if (!empty($query)) {
            $searchTerm = strtolower($query);
            
            // Filter guests in memory using collection methods for faster search
            $guests = $allGuests->filter(function ($guest) use ($searchTerm) {
                return str_contains(strtolower($guest->name ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->designation ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->company ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->category ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->proposalBy ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->guestOf ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->RSVP ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->tableAllocation ?? ''), $searchTerm) ||
                       str_contains(strtolower($guest->attendance ?? ''), $searchTerm);
            })->values();
        }

        return view('dashboard', [
            'guests' => $guests,
            'searchQuery' => $query,
        ]);
    }

    /**
     * Autocomplete lookup for guests.
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $query = trim($request->input('q', ''));
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $searchTerm = '%' . $query . '%';
        $guests = Guest::where(function($q) use ($searchTerm) {
            $q->where('name', 'like', $searchTerm)
              ->orWhere('designation', 'like', $searchTerm)
              ->orWhere('company', 'like', $searchTerm)
              ->orWhere('category', 'like', $searchTerm)
              ->orWhere('proposalBy', 'like', $searchTerm)
              ->orWhere('guestOf', 'like', $searchTerm)
              ->orWhere('RSVP', 'like', $searchTerm)
              ->orWhere('tableAllocation', 'like', $searchTerm)
              ->orWhere('attendance', 'like', $searchTerm);
        })
        ->limit(10)
        ->get()
        ->map(function ($guest) {
            return [
                'id' => $guest->id,
                'name' => $guest->name,
                'designation' => $guest->designation,
                'company' => $guest->company,
                'category' => $guest->category,
                'tableAllocation' => $guest->tableAllocation,
                'display' => $guest->name . 
                    ($guest->designation ? ' - ' . $guest->designation : '') . 
                    ($guest->company ? ' (' . $guest->company . ')' : ''),
            ];
        });

        return response()->json($guests);
    }

    /**
     * Mark guest as present.
     */
    public function markPresent(Request $request, Guest $guest): JsonResponse
    {
        $guest->update(['attendance' => 'Present']);

        return response()->json([
            'success' => true,
            'message' => 'Guest marked as present successfully',
            'attendance' => $guest->attendance,
        ]);
    }

    /**
     * Export guests to Excel (CSV format).
     */
    public function export(Request $request): StreamedResponse
    {
        $filename = 'guests_export_' . date('Y-m-d_His') . '.csv';

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
                'Designation',
                'Company',
                'Category',
                'Proposal By',
                'Guest Of',
                'RSVP',
                'Table Allocation',
                'Attendance',
                'Created At',
                'Updated At',
            ]);

            // Get all guests
            $guests = Guest::select([
                'id',
                'name',
                'designation',
                'company',
                'category',
                'proposalBy',
                'guestOf',
                'RSVP',
                'tableAllocation',
                'attendance',
                'created_at',
                'updated_at',
            ])->get();

            // Add guest data
            foreach ($guests as $guest) {
                fputcsv($file, [
                    $guest->id,
                    $guest->name,
                    $guest->designation ?? '',
                    $guest->company ?? '',
                    $guest->category ?? '',
                    $guest->proposalBy ?? '',
                    $guest->guestOf ?? '',
                    $guest->RSVP ?? '',
                    $guest->tableAllocation ?? '',
                    $guest->attendance ?? '',
                    $guest->created_at ? $guest->created_at->format('Y-m-d H:i:s') : '',
                    $guest->updated_at ? $guest->updated_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show attendance report.
     */
    public function report(Request $request): View
    {
        $totalGuests = Guest::count();
        $presentGuests = Guest::where('attendance', 'Present')->count();
        $absentGuests = Guest::where('attendance', 'Absent')->count();
        $notMarkedGuests = Guest::where(function($query) {
                $query->whereNull('attendance')
                      ->orWhere('attendance', '')
                      ->orWhere(function($q) {
                          $q->where('attendance', '!=', 'Present')
                            ->where('attendance', '!=', 'Absent');
                      });
            })->count();

        $presentList = Guest::where('attendance', 'Present')
            ->select([
                'id',
                'name',
                'designation',
                'company',
                'category',
                'tableAllocation',
                'attendance',
            ])
            ->orderBy('name')
            ->get();

        $absentList = Guest::where('attendance', 'Absent')
            ->select([
                'id',
                'name',
                'designation',
                'company',
                'category',
                'tableAllocation',
                'attendance',
            ])
            ->orderBy('name')
            ->get();

        $notMarkedList = Guest::where(function($query) {
                $query->whereNull('attendance')
                      ->orWhere('attendance', '')
                      ->orWhere(function($q) {
                          $q->where('attendance', '!=', 'Present')
                            ->where('attendance', '!=', 'Absent');
                      });
            })
            ->select([
                'id',
                'name',
                'designation',
                'company',
                'category',
                'tableAllocation',
                'attendance',
            ])
            ->orderBy('name')
            ->get();

        return view('guest.report', [
            'totalGuests' => $totalGuests,
            'presentGuests' => $presentGuests,
            'absentGuests' => $absentGuests,
            'notMarkedGuests' => $notMarkedGuests,
            'presentList' => $presentList,
            'absentList' => $absentList,
            'notMarkedList' => $notMarkedList,
        ]);
    }
}
