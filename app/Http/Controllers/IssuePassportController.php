<?php

namespace App\Http\Controllers;

use App\Http\Requests\PassportStoreRequest;
use App\Http\Requests\IssuePassportUpdateRequest;
use App\Models\Passport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IssuePassportController extends Controller
{
    public function index(Request $request): View
    {
        $passports = Passport::all()
        ->where('is_data_entered', '!=', null)
        ->where('issue', '!=', null);


        return view('issuepassport.index', compact('passports'));
    }

    public function create(Request $request): View
    {
        return view('issuepassport.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $passport = Passport::create($request->validated());

        $request->session()->flash('passport.id', $passport->id);

        return redirect()->route('issue-passports.index');
    }

    public function show(Request $request, $passport): View
    {
        return view('issuepassport.show', compact('passport'));
    }

    public function edit(Request $request, $passport): View
    {
        // dd($passport);
        $passport = Passport::find($passport);
        return view('issuepassport.edit', compact('passport'));
    }


    public function update(IssuePassportUpdateRequest $request, $passport): RedirectResponse
    {

        $passport = Passport::find($passport);

        $passport->is_passport = $request->has('is_passport');
        $passport->is_visa = $request->has('is_visa');
        $passport->is_photo = $request->has('is_photo');
        $passport->is_no_file_uploaded = $request->has('is_no_file_uploaded');

        // dd($passport->data_correct_value, $passport->verify_count);

        $verify_data_correct_count = $request->data_correct_value + $passport->verify_count;


        // $updated = $passport->update($request->all());


        // $updated = $passport->update(['is_data_entered' => true]);

        $updated = $passport->update(['verify_count' => $verify_data_correct_count]);

        
        if ($updated) {

            $request->session()->flash('passport.id', $passport->id);
            return redirect()->route('issue-passports.index')->with('success', 'Passport updated successfully');
        } else {
            return back()->with('error', 'Failed to update passport');
        }
    }

    

    public function destroy(Request $request, $passport): Response
    {
        $passport->delete();

        return redirect()->route('issue-passports.index');
    }
}
