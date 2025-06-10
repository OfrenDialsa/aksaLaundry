<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Pembayaran') }}
        </h2>
    </x-slot>

    @php
        $satuanOrders = $orders->where('type', 'satuan');
        $kiloanOrders = $orders->where('type', 'kiloan');
    @endphp

    <section class="mx-16 mt-6">
        <h3 class="text-2xl font-semibold mb-6 text-gray-900 border-b pb-2">Pesanan Laundry Satuan</h3>
        @forelse ($satuanOrders as $order)
            <div class="bg-white rounded-2xl shadow-md p-6 space-y-3 mb-8 transition-shadow hover:shadow-lg">
                <p class="text-xs text-gray-400 text-right font-mono">
                    {{ $order->created_at->format('d M Y, H:i') }}
                </p>

                <div class="bg-gray-50 rounded-xl border border-gray-300 p-4 text-sm space-y-3">
                    <div class="text-gray-500 font-mono text-sm space-y-1">
                        <p class="flex justify-between">
                            <span>Invoice:</span>
                            <span class="text-right truncate">{{ $order->midtrans_order_id ?? '-' }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span>User ID:</span>
                            <span class="text-right truncate">{{ $order->userId ?? '-' }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span>Nama:</span>
                            <span class="text-right truncate">{{ $order->name ?? '-' }}</span>
                        </p>
                    </div>

                    <p class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Status Pembayaran:</span>
                        <span class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                {{ $order->status_pembayaran === 'paid' ? 'bg-green-600' : 'bg-red-500' }}">
                            {{ ucfirst($order->status_pembayaran) }}
                        </span>
                    </p>

                    <div class="pt-3 border-t border-gray-200 space-y-1">
                        <p class="font-semibold text-gray-700">Detail Barang:</p>
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
                    </div>

                    <p class="flex justify-between font-semibold text-gray-900 mt-4">
                        <span>Total:</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 italic select-none">Belum ada pesanan laundry satuan.</p>
        @endforelse
    </section>

    <section class="mx-16 mb-10">
        <h3 class="text-2xl font-semibold mb-6 text-gray-900 border-b pb-2">Pesanan Laundry Kiloan</h3>
        @forelse ($kiloanOrders as $order)
            <div class="bg-white rounded-2xl shadow-md p-6 space-y-3 mb-8 transition-shadow hover:shadow-lg">
                <p class="text-xs text-gray-400 text-right font-mono">
                    {{ $order->created_at->format('d M Y, H:i') }}
                </p>

                <div class="bg-gray-50 rounded-xl border border-gray-300 p-4 text-sm space-y-3">
                    <div class="text-gray-500 font-mono text-sm space-y-1">
                        <p class="flex justify-between">
                            <span>Invoice:</span>
                            <span class="text-right truncate">{{ $order->midtrans_order_id ?? '-' }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span>User ID:</span>
                            <span class="text-right truncate">{{ $order->userId ?? '-' }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span>Nama:</span>
                            <span class="text-right truncate">{{ $order->name ?? '-' }}</span>
                        </p>
                    </div>

                    <p class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Status Pembayaran:</span>
                        <span class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                {{ $order->status_pembayaran === 'paid' ? 'bg-green-600' : 'bg-red-500' }}">
                            {{ ucfirst($order->status_pembayaran) }}
                        </span>
                    </p>

                    <div class="pt-3 border-t border-gray-200 flex justify-between items-center">
                        <p class="font-semibold text-gray-700 m-0">Berat Laundry:</p>
                        <p class="text-gray-900 font-semibold m-0">{{ $order->weight }} kg</p>
                    </div>

                    <p class="flex justify-between font-semibold text-gray-900 mt-4">
                        <span>Total:</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 italic select-none">Belum ada pesanan laundry kiloan.</p>
        @endforelse
    </section>
</x-admin-layout>