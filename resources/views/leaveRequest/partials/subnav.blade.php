<!-- Second Row Navigation for Leave Pages -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex space-x-8 py-2 bg-white border-b border-gray-200">
        @if (Auth::user()->is_admin)
        <div class="flex space-x-8">
            <x-nav-link :href="route('issue-leaves.index')" :active="request()->routeIs('issue-leaves.index')">
                {{ __('Issues') }}
            </x-nav-link>
        </div>
        @endif
        
        @if (Auth::user()->is_admin || Auth::user()->is_verifier)
        <div class="flex space-x-8">
            <x-nav-link :href="route('verify-leaves.index')" :active="request()->routeIs('verify-leaves.index')">
                {{ __('Verify') }}
            </x-nav-link>
        </div>
        @endif

        @if (Auth::user()->is_admin)
        <div class="flex space-x-8">
            <x-nav-link :href="route('LRadminpanel.index')" :active="request()->routeIs('LRadminpanel.index')">
                {{ __('Admin Panel') }}
            </x-nav-link>
        </div>
        @endif
    </div>
</div> 