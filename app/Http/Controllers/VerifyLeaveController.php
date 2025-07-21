<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequestStoreRequest;
use App\Http\Requests\LeaveRequestUpdateRequest;
use App\Models\LeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifyLeaveController extends Controller
{
    public function index(Request $request): View
    {
        $user_id = auth()->user()->id;
    
        $leaves = LeaveRequest::where('is_data_entered', 1)
        ->where('verify_count', '<', 2)
        // User must be assigned as a verifier
        ->where(function($query) use ($user_id) {
            $query->where('verifier1', $user_id)
                  ->orWhere('verifier2', $user_id);
        })
        // User must not have verified yet
        ->where(function($query) use ($user_id) {
            $query->where(function($q) use ($user_id) {
                // If user is verifier1, verifier1_id should be null
                $q->where('verifier1', $user_id)
                  ->whereNull('verifier1_id');
            })->orWhere(function($q) use ($user_id) {
                // If user is verifier2, verifier2_id should be null
                $q->where('verifier2', $user_id)
                  ->whereNull('verifier2_id');
            });
        })
        ->paginate(50); // Add pagination to prevent memory issues
    
        return view('LRverifyleave.index', compact('leaves'));
    }

    public function create(Request $request): View
    {
        return view('LRverifyleave.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $leave = LeaveRequest::create($request->validated());

        $request->session()->flash('leave.id', $leave->id);

        return redirect()->route('leave-requests.index');
    }

    public function show(Request $request, $leave): View
    {
        return view('verifyleave.show', compact('leave'));
    }

    public function edit(Request $request, $leave): View
    {
        $leave = LeaveRequest::findOrFail($leave);
        return view('verifyleave.edit', compact('leave'));
    }

    public function update(Request $request, $leave): RedirectResponse
    {
        $leave = LeaveRequest::findOrFail($leave);
    
        // update db "re_entry","is_data_entered" if the action is reentry OR update db "verify_count" if the action is verify
        switch($request->input('action')) {
            case 're-enter':
                $re_entry = $leave->re_entry + 1;
                $updated = $leave->update([
                    'is_data_correct' => 0,
                    'is_data_entered' => 0,
                    'verify_count' => 0,
                    're_entry' => $re_entry,
                ]);
    
                if ($updated) {
                    return redirect()->route('LRverify-leaves.index')
                                   ->with('success', 'Leave has been marked for re-entry');
                }
                return back()->with('error', 'Failed to mark leave for re-entry');
    
            case 'mark-as-verified':
                // Update verifier ID based on which verifier the user is
                if($leave->verifier1 == auth()->user()->id){
                    $leave->update(['verifier1_id' => auth()->user()->id]);
                }

                if($leave->verifier2 == auth()->user()->id){
                    $leave->update(['verifier2_id' => auth()->user()->id]);
                }
                
                $verify_data_correct_count = $request->data_correct_value + $leave->verify_count;
                
                $updated = $leave->update(['verify_count' => $verify_data_correct_count]);
                
                if ($updated) {
                    $request->session()->flash('leave.id', $leave->id);
                    return redirect()->route('LRverify-leaves.index')
                                   ->with('success', 'Leave updated successfully');
                }
                return back()->with('error', 'Failed to update leave');
        }
    }

    public function destroy(Request $request, $leave): RedirectResponse
    {
        $leave = LeaveRequest::findOrFail($leave);
        $leave->delete();

        return redirect()->route('LRverify-leaves.index');
    }
}
