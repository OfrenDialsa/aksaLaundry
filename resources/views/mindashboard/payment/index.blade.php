<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Pembayaran') }}
            </h2>

            <form method="GET" action="{{ route('invoice.monthly') }}" target="_blank"
                class="flex flex-col sm:flex-row sm:items-end gap-3 bg-white p-4 rounded-lg shadow w-full sm:w-auto">
                <div>
                    <select name="bulan" id="bulan"
                        class="w-full sm:w-40 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach (range(0, 11) as $i)
                            @php
                                $date = now()->subMonths($i);
                            @endphp
                            <option value="{{ $date->format('Y-m') }}">
                                {{ $date->translatedFormat('F Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    📄 Download Invoice
                </button>
            </form>
        </div>
    </x-slot>


    @php
        $satuanOrders = $orders->where('type', 'satuan');
        $kiloanOrders = $orders->where('type', 'kiloan');
    @endphp

    <section class="grid grid-cols-1 mt-6 mx-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($orders as $order)
            @php
                $statusPembayaran = match ($order->status_pembayaran) {
                    'unpaid' => 'Belum Bayar',
                    'pending' => 'Menunggu',
                    'paid' => 'Lunas',
                    default => ucfirst($order->status_pembayaran),
                };
            @endphp
            <div class="bg-white rounded-2xl shadow-md p-6 space-y-3 mb-8 transition-shadow hover:shadow-lg">
                <p class="text-xs text-gray-400 text-right font-mono">
                    {{ $order->created_at->format('d M Y, H:i') }}
                </p>

                <div class="bg-gray-50 rounded-xl border border-gray-300 p-4 text-sm space-y-3">
                    <div class="flex flex-col space-y-0">
                        <p class="flex justify-between">
                            <span class="text-gray-500">Invoice ID:</span>
                            <span class="text-gray-500 font-mono truncate">{{ $order->midtrans_order_id ?? '-' }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-500">User ID:</span>
                            <span class="text-gray-500 font-mono truncate">{{ $order->userId ?? '-' }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-500">Nama:</span>
                            <span class="text-gray-500 font-mono truncate">{{ $order->name ?? '-' }}</span>
                        </p>
                    </div>

                    <p class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Status Pembayaran:</span>
                        <span
                            class="px-3 py-1 rounded-full text-white text-xs font-semibold {{ $order->status_pembayaran === 'paid' ? 'bg-green-600' : 'bg-red-500' }}">
                            {{ $statusPembayaran }}
                        </span>
                    </p>

                    <div class="pt-3 border-t border-gray-200 space-y-1">
                        <p class="font-semibold text-gray-700">Jenis Layanan:
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded ml-2">
                                {{ ucfirst($order->type) }}
                            </span>
                        </p>

                        @if ($order->type === 'satuan')
                            @if($order->baju)
                                <p class="flex justify-between"><span>Baju</span><span>{{ $order->baju }} pcs</span></p>
                            @endif
                            @if($order->celana)
                                <p class="flex justify-between"><span>Celana</span><span>{{ $order->celana }} pcs</span></p>
                            @endif
                            @if($order->jaket)
                                <p class="flex justify-between"><span>Jaket</span><span>{{ $order->jaket }} pcs</span></p>
                            @endif
                            @if($order->gaun)
                                <p class="flex justify-between"><span>Gaun</span><span>{{ $order->gaun }} pcs</span></p>
                            @endif
                            @if($order->sprey_kasur)
                                <p class="flex justify-between"><span>Sprei Kasur</span><span>{{ $order->sprey_kasur }} pcs</span>
                                </p>
                            @endif
                        @elseif ($order->type === 'kiloan')
                            <p class="flex justify-between">
                                <span>Berat Laundry:</span>
                                <span>{{ $order->weight }} kg</span>
                            </p>
                        @endif
                    </div>

                    <p class="flex justify-between font-semibold text-gray-900 mt-4">
                        <span>Total:</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </p>

                    @if ($order->status === 'selesai' && $order->status_pembayaran !== 'paid')
                        <p class="text-xs text-gray-800 italic">
                            Menunggu <span class="text-green-600">Pembayaran</span>
                        </p>
                    @endif

                    @if ($order->status_pembayaran === 'paid')
                        <a href="{{ route('invoice.download', $order->id) }}"
                            class="inline-block mt-3 bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                            Cetak Invoice
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500 italic select-none">Belum ada pesanan laundry.</p>
        @endforelse
    </section>
</x-admin-layout>