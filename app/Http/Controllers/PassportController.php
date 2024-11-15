<?php

namespace App\Http\Controllers;

use App\Http\Requests\PassportStoreRequest;
use App\Http\Requests\PassportUpdateRequest;
use App\Models\Passport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PassportController extends Controller
{
    public function index(Request $request): Response
    {
        $passports = Passport::all();

        return view('passport.index', compact('passports'));
    }

    public function create(Request $request): Response
    {
        return view('passport.create');
    }

    public function store(PassportStoreRequest $request): Response
    {
        $passport = Passport::create($request->validated());

        $request->session()->flash('passport.id', $passport->id);

        return redirect()->route('passports.index');
    }

    public function show(Request $request, Passport $passport): Response
    {
        return view('passport.show', compact('passport'));
    }

    public function edit(Request $request, Passport $passport): View
    {
        return view('passport.edit', compact('passport'));
    }

    
    public function update(PassportUpdateRequest $request, Passport $passport): RedirectResponse
    {

        $passport->is_passport = $request->has('is_passport');
        $passport->is_visa = $request->has('is_visa');
        $passport->is_photo = $request->has('is_photo');
        $passport->is_no_file_uploaded = $request->has('is_no_file_uploaded');
        $passport->issue = $request->issue;

        if($passport->issue){
           $passport->is_issue = true;
        }

        
        
        $updated = $passport->update($request->all());


        $updated = $passport->update(['is_data_entered' => true]);

       
        
        if ($updated) {
            $request->session()->flash('passport.id', $passport->id);
            return redirect()->route('dashboard')->with('success', 'Passport updated successfully');
        } else {
            return back()->with('error', 'Failed to update passport');
        }
    }

    

    public function destroy(Request $request, Passport $passport): Response
    {
        $passport->delete();

        return redirect()->route('passports.index');
    }
}
