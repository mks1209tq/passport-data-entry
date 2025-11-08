<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestStoreRequest;
use App\Http\Requests\GuestUpdateRequest;
use App\Models\Guest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $guests = Guest::all();

        return view('guest.index', [
            'guests' => $guests,
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
}
