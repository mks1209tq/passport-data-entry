<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequestStoreRequest;
use App\Http\Requests\LeaveRequestUpdateRequest;
use App\Models\LeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaveRequestController extends Controller
{
    public function index(Request $request): View
    {
        $leaveRequests = LeaveRequest::all();

        return view('leaveRequest.index', compact('leaveRequests'));
    }

    public function create(Request $request): View
    {
        return view('leaveRequest.create');
    }

    public function store(LeaveRequestStoreRequest $request): RedirectResponse
    {
        $leaveRequest = LeaveRequest::create($request->validated());

        $request->session()->flash('leaveRequest.id', $leaveRequest->id);

        return redirect()->route('leaveRequests.index');
    }

    public function show(Request $request, LeaveRequest $leaveRequest): View
    {
        return view('leaveRequest.show', compact('leaveRequest'));
    }

    public function edit(Request $request, LeaveRequest $leaveRequest): View
    {
        return view('leaveRequest.edit', compact('leaveRequest'));
    }

    public function update(LeaveRequestUpdateRequest $request, LeaveRequest $leaveRequest): RedirectResponse
    {
        $leaveRequest->update($request->validated());

        $request->session()->flash('leaveRequest.id', $leaveRequest->id);

        return redirect()->route('leaveRequests.index');
    }

    public function destroy(Request $request, LeaveRequest $leaveRequest): RedirectResponse
    {
        $leaveRequest->delete();

        return redirect()->route('leaveRequests.index');
    }
}
