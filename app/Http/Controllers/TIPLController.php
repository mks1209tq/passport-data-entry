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
        return view('tipl.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TIPLStoreRequest $request): RedirectResponse
    {
        $tipl = TIPL::create($request->validated());

        $request->session()->flash('tipl.id', $tipl->id);

        return redirect()->route('tipl.index')->with('success', 'TIPL entry created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, TIPL $tipl): View
    {
        return view('tipl.show', [
            'tipl' => $tipl,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, TIPL $tipl): View
    {
        return view('tipl.edit', [
            'tipl' => $tipl,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TIPLUpdateRequest $request, TIPL $tipl): RedirectResponse
    {
        $tipl->update($request->validated());

        $request->session()->flash('tipl.id', $tipl->id);

        return redirect()->route('tipl.index')->with('success', 'TIPL entry updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TIPL $tipl): RedirectResponse
    {
        $tipl->delete();

        return redirect()->route('tipl.index')->with('success', 'TIPL entry deleted successfully');
    }
}
