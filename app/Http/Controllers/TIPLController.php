<?php

namespace App\Http\Controllers;

use App\Http\Requests\TIPLStoreRequest;
use App\Http\Requests\TIPLUpdateRequest;
use App\Models\TIPL;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TIPLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Only allow admin users to view the list
        if (!auth()->user() || !auth()->user()->isAdmin) {
            abort(403, 'Unauthorized action. Only administrators can view TIPL entries.');
        }

        $tipls = TIPL::orderBy('created_at', 'desc')->paginate(20);
        
        return view('tipl.index', [
            'tipls' => $tipls,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Check if registration is closed (255 entries limit)
        $totalEntries = TIPL::count();
        $isRegistrationClosed = $totalEntries >= 255;

        return view('tipl.create', [
            'isRegistrationClosed' => $isRegistrationClosed,
            'totalEntries' => $totalEntries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TIPLStoreRequest $request): RedirectResponse
    {
        // Check if registration is closed (255 entries limit)
        $totalEntries = TIPL::count();
        if ($totalEntries >= 255) {
            return redirect()->route('welcome')
                ->with('error', 'Registration is closed. Maximum of 255 entries have been reached.');
        }

        $tipl = TIPL::create($request->validated());

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
        // Only allow admin users to view details
        if (!auth()->user() || !auth()->user()->isAdmin) {
            abort(403, 'Unauthorized action. Only administrators can view TIPL entry details.');
        }

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
}
