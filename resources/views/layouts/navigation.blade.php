<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left side: Logo -->
            <div class="flex items-center">
                <a href="/" class="text-xl font-bold text-blue-400 hover:text-blue-500">AksaLaundry</a>
            </div>

            <!-- Navigation Links (desktop) -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                <x-nav-link :href="route('dashboard.order.index')" :active="request()->routeIs('dashboard.order.index')">
                    {{ __('Mulai Pesan') }}
                </x-nav-link>
                <x-nav-link :href="route('dashboard.location')" :active="request()->routeIs('dashboard.location')">
                    {{ __('Cek Lokasi') }}
                </x-nav-link>
                <x-nav-link :href="route('dashboard.ourlocation')" :active="request()->routeIs('dashboard.ourlocation')">
                    {{ __('Lokasi AksaLaundry') }}
                </x-nav-link>
                <x-nav-link :href="route('dashboard.payment.index')" :active="request()->routeIs('dashboard.payment.index')">
                    {{ __('Pembayaran') }}
                </x-nav-link>
                <x-nav-link :href="route('dashboard.prices.index')" :active="request()->routeIs('dashboard.prices.index')">
                    {{ __('Harga') }}
                </x-nav-link>
            </div>

            <!-- Right side: User dropdown -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 transition">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (mobile) -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-400 transition">
                    <span class="sr-only">Open main menu</span>
                    <svg x-show="!open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="sm:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard.order.index')" :active="request()->routeIs('dashboard.order.index')">
                {{ __('Mulai Pesan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.location')" :active="request()->routeIs('dashboard.location')">
                {{ __('Cek Lokasi') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.ourlocation')" :active="request()->routeIs('dashboard.ourlocation')">
                {{ __('Lokasi AksaLaundry') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.payment.index')" :active="request()->routeIs('dashboard.payment.index')">
                {{ __('Pembayaran') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.prices.index')" :active="request()->routeIs('dashboard.prices.index')">
                {{ __('Harga') }}
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-gray-200 pt-4 pb-3">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
