@extends('welcome')

@section('content')
    <div class="flex items-center justify-between w-full px-6 py-16 rounded-lg mx-4 lg:mx-16 flex-col lg:flex-row gap-10">
        <!-- Left side: Text content -->
        <div class="flex flex-col max-w-xl text-center lg:text-left">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-4">
                Welcome to AksaLaundry
            </h1>
            <p class="text-blue-700 mb-6">
                Fast, reliable laundry services right at your doorstep. Experience convenience like never before.
            </p>
            <a href="@auth
                    {{ auth()->user()->usertype === 'admin'
                ? route('mindashboard.order.index')
                : route('dashboard.order.index') }}
            @else
                {{ route('login') }}
            @endauth"
                class="inline-block px-8 py-3 bg-blue-600 text-white rounded-full font-semibold hover:bg-blue-700 transition">
                Get Started
            </a>
        </div>

        <!-- Right side: Hero image -->
        <div class="flex justify-center lg:justify-end max-w-md">
            <img src="{{ asset('images/HeroSectionImage.png') }}" alt="Laundry service illustration"
                class="w-full h-auto max-w-xs lg:max-w-md rounded-lg" />
        </div>
    </div>
@endsection