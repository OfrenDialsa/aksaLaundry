@extends('welcome')

@section('content')
<div class="flex flex-col items-center justify-center w-full px-6 py-16 rounded-lg mx-4 lg:mx-16 gap-10">
    <!-- Page Heading -->
    <div class="text-center max-w-3xl">
        <h1 class="text-4xl font-extrabold text-blue-900 mb-4">
            Frequently Asked Questions
        </h1>
        <p class="text-blue-700 mb-6">
            Got questions? We've compiled a list of the most commonly asked questions to help you out.
        </p>
    </div>

    <!-- FAQ List -->
    <div class="w-full max-w-3xl space-y-6">
        <div class="bg-blue-50 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-blue-800 mb-2">What services do you offer?</h2>
            <p class="text-blue-700">
                We provide wash & fold, dry cleaning, ironing, and pickup & delivery services tailored to your needs.
            </p>
        </div>
        <div class="bg-blue-50 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-blue-800 mb-2">How do I schedule a pickup?</h2>
            <p class="text-blue-700">
                Simply log in to your account and schedule a pickup time through your dashboard.
            </p>
        </div>
        <div class="bg-blue-50 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-blue-800 mb-2">What areas do you serve?</h2>
            <p class="text-blue-700">
                We currently serve select areas in the city. Check our service coverage on the dashboard or contact support.
            </p>
        </div>
        <div class="bg-blue-50 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-blue-800 mb-2">How long does it take to get my laundry back?</h2>
            <p class="text-blue-700">
                Turnaround time is typically 24–48 hours depending on the service selected.
            </p>
        </div>
    </div>
</div>
@endsection
