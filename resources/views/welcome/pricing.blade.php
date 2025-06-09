@extends('welcome')

@section('content')
<div class="flex items-center justify-center w-full px-6 py-16 rounded-lg mx-4 lg:mx-16 flex-col text-center">
    <div class="max-w-3xl">
        <h1 class="text-4xl font-extrabold text-blue-900 mb-4">
            Transparent & Affordable Pricing
        </h1>
        <p class="text-blue-700 mb-6 text-lg">
            Choose a plan that fits your laundry needs. No hidden fees — just fast, clean, and reliable service.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left mt-8">
            <!-- Basic Plan -->
            <div class="p-6 bg-white rounded-xl shadow-md border border-blue-100">
                <h2 class="text-xl font-semibold text-blue-800 mb-2">Basic</h2>
                <p class="text-sm text-gray-600 mb-4">Ideal for occasional laundry needs.</p>
                <ul class="text-sm text-gray-700 mb-4 space-y-1">
                    <li>✔ 5 kg/week</li>
                    <li>✔ 2-day turnaround</li>
                    <li>✔ Standard detergent</li>
                </ul>
                <p class="text-blue-900 font-bold text-lg">Rp30.000/week</p>
            </div>

            <!-- Standard Plan -->
            <div class="p-6 bg-white rounded-xl shadow-md border border-blue-100">
                <h2 class="text-xl font-semibold text-blue-800 mb-2">Standard</h2>
                <p class="text-sm text-gray-600 mb-4">Perfect for small families.</p>
                <ul class="text-sm text-gray-700 mb-4 space-y-1">
                    <li>✔ 10 kg/week</li>
                    <li>✔ Next-day delivery</li>
                    <li>✔ Fabric softener included</li>
                </ul>
                <p class="text-blue-900 font-bold text-lg">Rp50.000/week</p>
            </div>

            <!-- Premium Plan -->
            <div class="p-6 bg-white rounded-xl shadow-md border border-blue-100">
                <h2 class="text-xl font-semibold text-blue-800 mb-2">Premium</h2>
                <p class="text-sm text-gray-600 mb-4">For frequent or large loads.</p>
                <ul class="text-sm text-gray-700 mb-4 space-y-1">
                    <li>✔ 20 kg/week</li>
                    <li>✔ Same-day service</li>
                    <li>✔ Custom detergent options</li>
                </ul>
                <p class="text-blue-900 font-bold text-lg">Rp90.000/week</p>
            </div>
        </div>
    </div>
</div>
@endsection