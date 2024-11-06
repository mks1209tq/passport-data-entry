<?php

namespace App\Http\Controllers;

use App\Http\Requests\PassportStoreRequest;
use App\Http\Requests\PassportUpdateRequest;
use App\Models\Passport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifyPassportController extends Controller
{
    public function index(Request $request): View
    {
        $user_id = auth()->user()->id;
    
        $passports = Passport::where('is_data_entered', 1)
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
    
        return view('verifypassport.index', compact('passports'));
    }

    public function create(Request $request): View
    {
        return view('verifypassport.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $passport = Passport::create($request->validated());

        $request->session()->flash('passport.id', $passport->id);

        return redirect()->route('passports.index');
    }

    public function show(Request $request, $passport): View
    {
        return view('verifypassport.show', compact('passport'));
    }

    public function edit(Request $request, $passport): View
    {
        // dd($passport);
        $passport = Passport::find($passport);
        return view('verifypassport.edit', compact('passport'));
    }


    public function update(Request $request, $passport): RedirectResponse
    {

        $passport = Passport::find($passport);
    
        // update db "re_entry","is_data_entered" if the action is reentry OR update db "verify_count" if the action is verify
        switch($request->input('action')) {
            case 're-enter':
                $re_entry = $passport->re_entry + 1;
                $updated = $passport->update([
                    'is_data_correct' => 0,
                    'is_data_entered' => 0,
                    'passport_expiry_date' => null,
                    'visa_expiry_date' => null,
                    'is_passport' => 0,
                    'is_visa' => 0,
                    'is_photo' => 0,
                    'is_no_file_uploaded' => 0,
                    'verify_count' => 0,
                    're_entry' => $re_entry,
                    
                ]);
    
                if ($updated) {
                    return redirect()->route('verify-passports.index')
                                   ->with('success', 'Passport has been marked for re-entry');
                }
                return back()->with('error', 'Failed to mark passport for re-entry');
    
            case 'mark-as-verified':

                // dd($passport->verifier1, $passport->verifier2);
                $verify_data_correct_count = $passport->verify_count;



                // if($verify_data_correct_count == 0){
                //     $passport->update(['verifier1_id' => auth()->user()->id]);
                // }

                // if($verify_data_correct_count == 1){
                //     $passport->update(['verifier2_id' => auth()->user()->id]);
                // }             
                
                if($passport->verifier1 == auth()->user()->id){
                    $passport->update(['verifier1_id' => auth()->user()->id]);
                }

                if($passport->verifier2 == auth()->user()->id){
                    $passport->update(['verifier2_id' => auth()->user()->id]);
                }
                
                
                $verify_data_correct_count = $request->data_correct_value + $passport->verify_count;
                
                $updated = $passport->update(['verify_count' => $verify_data_correct_count]);

                
                
                if ($updated) {
                    $request->session()->flash('passport.id', $passport->id);
                    return redirect()->route('verify-passports.index')
                                   ->with('success', 'Passport updated successfully');
                }
                return back()->with('error', 'Failed to update passport');
        }
    }

    

    public function destroy(Request $request, $passport): Response
    {
        $passport->delete();

        return redirect()->route('verifypassport.index');
    }
}
