<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Passport;

class AdminPanelController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        return view('adminpanel.index', [
            'users' => User::all(),
             'passports' => Passport::all(),
             'admins' => User::where('is_admin', true)->get(),
             'verifiers' => User::where('is_verifier', true)->get(),
             'non_admins' => User::where('is_admin', false)->get(),
             'non_verifiers' => User::where('is_verifier', false)->get(),
        ]);
    }

    

    public function assignPassports(Request $request): RedirectResponse {

        $count = $request->input('count', 10);
        Artisan::call('passports:assign', [
            'count' => $count
        ]);
        return redirect()->back()->with('success', 'Passports assigned successfully');
    }

    public function assignUsers(Request $request): RedirectResponse {

        $userIds = $request->input('users');
        $count = $request->input('count');
        
        Artisan::call('passports:assign-one', [
            'count' => $count,
            'users' => $userIds
        ]);
        return redirect()->back()->with('success', 'Passports assigned successfully');
    }


    public function assignVerifiers(Request $request): RedirectResponse {

        
        $count = $request->input('count');
        
        Artisan::call('pv:assign', [
            'count' => $count,
            
        ]);
        return redirect()->back()->with('success', 'Passports assigned successfully');
    }

// ... existing code ...

public function setAdmin(Request $request): RedirectResponse
{
    $selectedUsers = $request->input('selected_users', []);
    
    // Set all users to non-admin first
    User::query()->update(['is_admin' => false]);
    
    // Then set selected users as admin
    if (!empty($selectedUsers)) {
        User::whereIn('id', $selectedUsers)->update(['is_admin' => true]);
    }
    
    return redirect()->back()->with('success', 'Admin status updated successfully');
}


public function setVerifier(Request $request): RedirectResponse
{
    $selectedUsers = $request->input('selected_users', []);
    
    // Set all users to non-admin first
    User::query()->update(['is_verifier' => false]);
    
    // Then set selected users as admin
    if (!empty($selectedUsers)) {
        User::whereIn('id', $selectedUsers)->update(['is_verifier' => true]);
    }
    
    return redirect()->back()->with('success', 'Verifier status updated successfully');
}

public function removeVerifierAssignments(Request $request): RedirectResponse
{
    $userId = $request->input('user_id');
    Artisan::call('verifier:remove', ['user_ids' => [$userId]]);
    return redirect()->back()->with('success', 'Verifier assignments removed successfully');
}

    
}
