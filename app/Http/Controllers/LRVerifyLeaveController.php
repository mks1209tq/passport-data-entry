<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequestStoreRequest;
use App\Http\Requests\LeaveRequestUpdateRequest;
use App\Models\LeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LRVerifyLeaveController extends Controller
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
        ->get();    
    
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

        return redirect()->route('leaves.index');
    }

    public function show(Request $request, LeaveRequest $leave): View
    {
        return view('LRverifyleave.show', compact('leave'));
    }

    public function edit(Request $request, LeaveRequest $leave): View
    {
        // dd($leave);
        $leaveRequest = $leave;
        return view('LRverifyleave.edit', compact('leaveRequest'));
    }


    public function update(Request $request, LeaveRequest $leave): RedirectResponse
    {
        $leaveRequest = $leave;
    
        // update db "re_entry","is_data_entered" if the action is reentry OR update db "verify_count" if the action is verify
        switch($request->input('action')) {
            case 're-enter':
                $re_entry = $leaveRequest->re_entry + 1;
                $updated = $leaveRequest->update([
                    'is_data_correct' => 0,
                    'is_data_entered' => 0,
                    'verify_count' => 0,
                    're_entry' => $re_entry,
                    'verifier1_id' => null,
                    'verifier2_id' => null
                    
                ]);
    
                if ($updated) {
                    return redirect()->route('verify-leaves.index')
                                   ->with('success', 'leave has been marked for re-entry');
                }
                return back()->with('error', 'Failed to mark leave for re-entry');
    
            case 'mark-as-verified':

                // dd($leaveRequest->verifier1, $leaveRequest->verifier2);
                $verify_data_correct_count = $leaveRequest->verify_count;



                // if($verify_data_correct_count == 0){
                //     $leaveRequest->update(['verifier1_id' => auth()->user()->id]);
                // }

                // if($verify_data_correct_count == 1){
                //     $leaveRequest->update(['verifier2_id' => auth()->user()->id]);
                // }             
                
                if($leaveRequest->verifier1 == auth()->user()->id){
                    $leaveRequest->update(['verifier1_id' => auth()->user()->id]);
                }

                if($leaveRequest->verifier2 == auth()->user()->id){
                    $leaveRequest->update(['verifier2_id' => auth()->user()->id]);
                }
                
                
                $verify_data_correct_count = $request->data_correct_value + $leaveRequest->verify_count;
                
                $updated = $leaveRequest->update(['verify_count' => $verify_data_correct_count]);

                
                
                if ($updated) {
                    $request->session()->flash('leave.id', $leaveRequest->id);
                    return redirect()->route('verify-leaves.index')
                                   ->with('success', 'leave updated successfully');
                }
                return back()->with('error', 'Failed to update leave');
        }
    }

    

    public function destroy(Request $request, LeaveRequest $leave): Response
    {
        $leave->delete();

        return redirect()->route('verifyleave.index');
    }
}
