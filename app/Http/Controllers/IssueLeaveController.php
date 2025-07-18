<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Http\Requests\LeaveRequestStoreRequest;
use App\Http\Requests\IssueLeaveUpdateRequest;
use App\Models\LeaveRequest;
=======
use App\Http\Requests\LeaveStoreRequest;
use App\Http\Requests\IssueLeaveUpdateRequest;
use App\Models\Leave;
>>>>>>> 1929c2966888e06efc246b1652928ec2f7f69d95
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IssueLeaveController extends Controller
{
    public function index(Request $request): View
    {
<<<<<<< HEAD
        $leaveRequests = LeaveRequest::all()
=======
        $leaves = Leave::all()
>>>>>>> 1929c2966888e06efc246b1652928ec2f7f69d95
        // ->where('is_data_entered', '!=', null)
        ->where('is_issue', true);


<<<<<<< HEAD
        return view('LRissueleave.index', compact('leaveRequests'));
=======
        return view('issueleave.index', compact('leaves'));
>>>>>>> 1929c2966888e06efc246b1652928ec2f7f69d95
    }

    public function create(Request $request): View
    {
<<<<<<< HEAD
        return view('LRissueleave.create');
=======
        return view('issueleave.create');
>>>>>>> 1929c2966888e06efc246b1652928ec2f7f69d95
    }

    public function store(Request $request): RedirectResponse
    {
<<<<<<< HEAD
        $leave = LeaveRequest::create($request->validated());
=======
        $leave = Leave::create($request->validated());
>>>>>>> 1929c2966888e06efc246b1652928ec2f7f69d95

        $request->session()->flash('leave.id', $leave->id);

        return redirect()->route('issue-leaves.index');
    }

    public function show(Request $request, $leave): View
    {
<<<<<<< HEAD
        return view('LRissueleave.show', compact('leave'));
=======
        return view('issueleave.show', compact('leave'));
>>>>>>> 1929c2966888e06efc246b1652928ec2f7f69d95
    }

    public function edit(Request $request, $leave): View
    {
        // dd($leave);
<<<<<<< HEAD
        $leave = LeaveRequest::find($leave);
        return view('LRissueleave.edit', compact('leave'));
=======
        $leave = Leave::find($leave);
        return view('issueleave.edit', compact('leave'));
>>>>>>> 1929c2966888e06efc246b1652928ec2f7f69d95
    }


    public function update(IssueLeaveUpdateRequest $request, $leave): RedirectResponse
    {

<<<<<<< HEAD
        $leave = LeaveRequest::find($leave);
=======
        $leave = Leave::find($leave);
>>>>>>> 1929c2966888e06efc246b1652928ec2f7f69d95

        $leave->is_leave = $request->has('is_leave');
        $leave->is_visa = $request->has('is_visa');
        $leave->is_photo = $request->has('is_photo');
        $leave->is_no_file_uploaded = $request->has('is_no_file_uploaded');
        $leave->is_issue = $request->has('is_issue');
        
<<<<<<< HEAD
     
=======
       
        // dd($leave->data_correct_value, $leave->verify_count);

        // $verify_data_correct_count = $request->data_correct_value + $leave->verify_count;
>>>>>>> 1929c2966888e06efc246b1652928ec2f7f69d95


        $updated = $leave->update($request->all());


<<<<<<< HEAD
=======
        // $updated = $leave->update(['is_data_entered' => true]);

        // $updated = $leave->update(['issue' => 'a']);
>>>>>>> 1929c2966888e06efc246b1652928ec2f7f69d95

        
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
