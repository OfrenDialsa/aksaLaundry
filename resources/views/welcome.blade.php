<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AksaLaundry</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] font-sans min-h-screen">

    <!-- Navbar -->
    <header class="w-full text-sm px-4 py-4 shadow-md bg-white sticky top-0 z-50">
        @if (Route::has('login'))
            <nav class="flex items-center justify-between mx-16">
                <!-- Left side: Logo + Links -->
                <div class="flex items-center gap-6 text-[#1b1b18]">
                    <!-- Logo -->
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/AksaLaundry.png') }}" alt="AksaLaundry Logo" class="h-12 w-auto">
                    </a>

                    <!-- Nav Links -->
                    <div class="flex items-center gap-4">
                        <a href="{{ url('/welcome/home') }}"
                            class="relative inline-block after:block after:h-[2px] font-medium after:bg-blue-300 after:origin-left after:transition-transform after:duration-300
                            {{ request()->is('welcome/home') ? 'after:scale-x-100' : 'after:scale-x-0 hover:after:scale-x-100' }}">
                            Home
                        </a>

                        <a href="{{ url('/welcome/pricing') }}"
                            class="relative inline-block after:block after:h-[2px] font-medium after:bg-blue-300 after:origin-left after:transition-transform after:duration-300
                            {{ request()->is('welcome/pricing') ? 'after:scale-x-100' : 'after:scale-x-0 hover:after:scale-x-100' }}">
                            Pricing
                        </a>

                        <a href="{{ url('/welcome/faq') }}"
                            class="relative inline-block after:block after:h-[2px] font-medium after:bg-blue-300 after:origin-left after:transition-transform after:duration-300
                            {{ request()->is('welcome/faq') ? 'after:scale-x-100' : 'after:scale-x-0 hover:after:scale-x-100' }}">
                            FAQs
                        </a>

                        <a href="{{ url('/welcome/about') }}"
                            class="relative inline-block after:block after:h-[2px] font-medium after:bg-blue-300 after:origin-left after:transition-transform after:duration-300
                            {{ request()->is('welcome/about') ? 'after:scale-x-100' : 'after:scale-x-0 hover:after:scale-x-100' }}">
                            About Us
                        </a>
                    </div>
                </div>

                <!-- Right side: Auth links -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard/order') }}"
                            class="inline-block px-5 py-1.5 bg-blue-500 hover:bg-blue-400 text-white rounded-full text-sm transition duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-full text-sm transition duration-200">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-full text-sm transition duration-200">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            </nav>
        @endif
    </header>

    <!-- Page Content -->
    <main class="w-full max-w-7xl mx-auto px-4 py-10">
        @yield('content')
    </main>

</body>

</html>