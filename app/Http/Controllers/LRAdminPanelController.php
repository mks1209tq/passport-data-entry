<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\LeaveRequest;

class LRAdminPanelController extends Controller
{
    /**
     * Display the admin panel.
     */
    public function index(Request $request): View
    {
        return view('LRadminpanel.index', [
            'users' => User::all(),
            'leaves' => LeaveRequest::all(),
            'admins' => User::where('is_admin', true)->get(),
            'verifiers' => User::where('is_verifier', true)->get(),
            'non_admins' => User::where('is_admin', false)->get(),
            'non_verifiers' => User::where('is_verifier', false)->get(),
        ]);
    }

    public function assignLeaves(Request $request): RedirectResponse
    {
        $count = $request->input('count', 10);
        Artisan::call('leaves:assign', [
            'count' => $count
        ]);
        return redirect()->back()->with('success', 'Leaves assigned successfully');
    }

    public function assignUsers(Request $request): RedirectResponse
    {
        $userIds = $request->input('users');
        $count = $request->input('count');
        
        Artisan::call('leaves:assign-one', [
            'count' => $count,
            'users' => $userIds
        ]);
        return redirect()->back()->with('success', 'Leaves assigned successfully');
    }

    public function assignVerifiers(Request $request): RedirectResponse
    {
        $count = $request->input('count');
        
        Artisan::call('lv:assign', [
            'count' => $count,
        ]);
        return redirect()->back()->with('success', 'Leaves assigned successfully');
    }

    public function setAdmin(Request $request): RedirectResponse
    {
        $selectedUsers = $request->input('selected_users', []);
        
        User::query()->update(['is_admin' => false]);
        
        if (!empty($selectedUsers)) {
            User::whereIn('id', $selectedUsers)->update(['is_admin' => true]);
        }
        
        return redirect()->back()->with('success', 'Admin status updated successfully');
    }

    public function setVerifier(Request $request): RedirectResponse
    {
        $selectedUsers = $request->input('selected_users', []);
        
        User::query()->update(['is_verifier' => false]);
        
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

    public function removeLeaveAssignments(Request $request): RedirectResponse
    {
        $userId = $request->input('user_id');
        Artisan::call('leave:remove', ['user_ids' => [$userId]]);
        return redirect()->back()->with('success', 'Leave assignments removed successfully');
    }
}
