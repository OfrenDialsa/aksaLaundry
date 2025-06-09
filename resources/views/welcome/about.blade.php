@extends('welcome')

@section('content')
<div class="flex flex-col items-center justify-center w-full px-6 py-16 rounded-lg mx-4 lg:mx-16 gap-10">
    <!-- Page Heading -->
    <div class="text-center max-w-3xl">
        <h1 class="text-4xl font-extrabold text-blue-900 mb-4">
            About AksaLaundry
        </h1>
        <p class="text-blue-700 mb-6">
            Learn more about who we are, what we stand for, and how we're redefining convenience in laundry services.
        </p>
    </div>

    <!-- About Content -->
    <div class="w-full max-w-3xl space-y-6 text-blue-700">
        <div class="bg-blue-50 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-blue-800 mb-2">Our Mission</h2>
            <p>
                At AksaLaundry, our mission is to make laundry day effortless. We’re committed to delivering fast, reliable, and affordable laundry services, so you can focus on what truly matters.
            </p>
        </div>
        <div class="bg-blue-50 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-blue-800 mb-2">Our Story</h2>
            <p>
                Founded in 2023, AksaLaundry began with a simple idea: make clean clothes more accessible. What started as a small local service has grown into a trusted name in modern, tech-enabled laundry care.
            </p>
        </div>
        <div class="bg-blue-50 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-blue-800 mb-2">Why Choose Us?</h2>
            <ul class="list-disc list-inside space-y-1">
                <li>Timely pickups and deliveries</li>
                <li>Eco-friendly cleaning practices</li>
                <li>Affordable and transparent pricing</li>
                <li>Exceptional customer support</li>
            </ul>
        </div>
        <div class="bg-blue-50 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-blue-800 mb-2">Our Vision</h2>
            <p>
                We envision a future where laundry is no longer a chore. Through technology and dedication, we aim to become the go-to laundry solution for households and businesses across the region.
            </p>
        </div>
    </div>
</div>
@endsection
