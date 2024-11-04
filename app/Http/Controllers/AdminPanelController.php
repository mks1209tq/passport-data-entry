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
class AdminPanelController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        return view('adminpanel.index', [
            'users' => User::all()
                        ->where('is_admin', false)
                        ->where('is_verifier', false),
            // 'user' => $request->user(),
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

    
}
