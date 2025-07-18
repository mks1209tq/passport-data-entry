<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequestStoreRequest;
use App\Http\Requests\IssueLeaveUpdateRequest;
use App\Models\LeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IssueLeaveController extends Controller
{
    public function index(Request $request): View
    {
        $leaveRequests = LeaveRequest::all()
        // ->where('is_data_entered', '!=', null)
        ->where('is_issue', true);


        return view('LRissueleave.index', compact('leaveRequests'));
    }

    public function create(Request $request): View
    {
        return view('LRissueleave.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $leave = LeaveRequest::create($request->validated());

        $request->session()->flash('leave.id', $leave->id);

        return redirect()->route('issue-leaves.index');
    }

    public function show(Request $request, $leave): View
    {
        return view('LRissueleave.show', compact('leave'));
    }

    public function edit(Request $request, $leave): View
    {
        // dd($leave);
        $leave = LeaveRequest::find($leave);
        return view('LRissueleave.edit', compact('leave'));
    }


    public function update(IssueLeaveUpdateRequest $request, $leave): RedirectResponse
    {

        $leave = LeaveRequest::find($leave);

        $leave->is_leave = $request->has('is_leave');
        $leave->is_visa = $request->has('is_visa');
        $leave->is_photo = $request->has('is_photo');
        $leave->is_no_file_uploaded = $request->has('is_no_file_uploaded');
        $leave->is_issue = $request->has('is_issue');
        
     


        $updated = $leave->update($request->all());



        
        if ($updated) {

            $request->session()->flash('leave.id', $leave->id);
            return redirect()->route('issue-leaves.index')->with('success', 'Leave updated successfully');
        } else {
            return back()->with('error', 'Failed to update leave');
        }
    }

    

    public function destroy(Request $request, $leave): Response
    {
        $leave->delete();

        return redirect()->route('issue-leaves.index');
    }
}
