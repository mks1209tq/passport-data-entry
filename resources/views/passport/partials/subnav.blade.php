<!-- Second Row Navigation for Passport Pages -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex space-x-8 py-2 bg-white border-b border-gray-200">
        <div class="flex space-x-8">
            <x-nav-link :href="route('ppdashboard')" :active="request()->routeIs('ppdashboard')">
                {{ __('Passport') }}
            </x-nav-link>
        </div>
        
        @if (Auth::user()->is_admin)
        <div class="flex space-x-8">
            <x-nav-link :href="route('issue-passports.index')" :active="request()->routeIs('issue-passports.index')">
                {{ __('Issues') }}
            </x-nav-link>
        </div>
        @endif
        
        @if (Auth::user()->is_admin || Auth::user()->is_verifier)
        <div class="flex space-x-8">
            <x-nav-link :href="route('verify-passports.index')" :active="request()->routeIs('verify-passports.index')">
                {{ __('Verify') }}
            </x-nav-link>
        </div>
        @endif

        @if (Auth::user()->is_admin)
        <div class="flex space-x-8">
            <x-nav-link :href="route('adminpanel.index')" :active="request()->routeIs('adminpanel.index')">
                {{ __('Admin Panel') }}
            </x-nav-link>
        </div>
        @endif
    </div>
</div> 