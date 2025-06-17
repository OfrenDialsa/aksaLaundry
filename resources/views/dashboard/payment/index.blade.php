<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Pembayaran') }}
        </h2>
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
                    <p class="flex justify-between">
                        <span class="font-semibold text-gray-700">Invoice ID:</span>
                        <span class="text-gray-700 font-mono truncate">{{ $order->midtrans_order_id ?? '-' }}</span>
                    </p>

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

                    @if ($order->status === 'menunggu' && $order->status_pembayaran === 'unpaid')
                        <p class="text-xs text-gray-800 italic">
                            Silakan bayar dahulu sebelum di <span class="text-orange-600">proses/jemput</span>
                        </p>

                        <button class="pay-button bg-blue-600 text-white px-3 py-1 rounded" data-order-id="{{ $order->id }}">
                            Bayar
                        </button>
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


    <!-- Midtrans Snap.js -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.querySelectorAll('.pay-button').forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.dataset.orderId;

                fetch(`/dashboard/payment/${orderId}/checkout`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.token) {
                            window.snap.pay(data.token, {
                                onSuccess: function (result) {
                                    alert("Pembayaran berhasil!");
                                    location.reload();
                                },
                                onPending: function (result) {
                                    alert("Menunggu pembayaran...");
                                    location.reload();
                                },
                                onError: function (result) {
                                    alert("Terjadi kesalahan saat pembayaran.");
                                    console.error(result);
                                },
                                onClose: function () {
                                    alert("Anda menutup popup pembayaran.");
                                }
                            });
                        } else {
                            alert("Gagal mendapatkan token pembayaran.");
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert("Terjadi kesalahan saat memproses pembayaran.");
                    });
            });
        });
    </script>
</x-app-layout>