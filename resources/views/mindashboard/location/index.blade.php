<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cek Lokasi Cucianmu') }}
        </h2>
    </x-slot>

    <div class="w-full p-6 mt-5 space-y-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
            @forelse ($orders as $order)
                @php
                    $bgColor = match ($order->status) {
                        'dijemput' => 'bg-orange-100',
                        'selesai' => 'bg-green-100',
                        default => 'bg-white',
                    };

                @endphp
                <div
                    class="rounded-xl shadow-md p-5 space-y-4 hover:shadow-lg transition-transform hover:scale-[1.02] {{ $order->status === 'dijemput' ? 'bg-orange-100' : ($order->status === 'diproses' ? 'bg-blue-100' : 'bg-white') }}">

                    <h3 class=" text-lg font-semibold text-blue-500">Laundry {{ $order->type ?? 'Yes' }}</h3>

                    <div class="text-sm text-gray-600 space-y-1">
                        <p><strong>Invoice:</strong> {{ $order->midtrans_order_id ?? '-' }}</p>
                        <p><strong>User ID:</strong> {{ $order->userId ?? '-' }}</p>
                        <p><strong>Nama:</strong> {{ $order->name ?? '-' }}</p>
                    </div>

                    @if ($order->status === 'dijemput')
                        <div class="text-sm font-semibold text-orange-600">🚗 Sedang dijemput...</div>
                    @elseif ($order->status === 'diproses')
                        <div class="text-sm font-semibold text-blue-600">~ Sedang di proses...</div>
                    @endif

                    @if ($order->latitude && $order->longitude)
                        <iframe
                            src="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&hl=es;z=14&output=embed"
                            width="100%" height="250" class="rounded-lg border" allowfullscreen loading="lazy">
                        </iframe>
                    @else
                        <p class="text-red-500 text-sm italic">Lokasi tidak tersedia.</p>
                    @endif

                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                        @if ($order->latitude && $order->longitude)
                            <a href="https://www.google.com/maps/dir/?api=1&origin=-1.622760156469893,103.5411668963064&destination={{ $order->latitude }},{{ $order->longitude }}"
                                target="_blank" class="text-blue-600 font-semibold hover:underline">
                                Lihat Rute
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-400 italic">
                    Tidak ada pesanan jemput saat ini.
                </div>
            @endforelse
        </div>
    </div>
</x-admin-layout>