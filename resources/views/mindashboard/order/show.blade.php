<x-admin-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 md:p-8 rounded-2xl shadow-lg mt-6 space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan</h2>
            <span class="text-sm px-3 py-1 rounded-full text-white 
                {{ $order->status === 'menunggu' ? 'bg-amber-500' :
    ($order->status === 'dijemput' ? 'bg-orange-500' :
        ($order->status === 'diproses' ? 'bg-sky-500' :
            ($order->status === 'selesai' ? 'bg-emerald-500' : 'bg-rose-500'))) }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 text-gray-700 text-sm">
            <p><span class="font-medium">Invoice:</span> {{ ucfirst($order->midtrans_order_id) }}</p>
            <p><span class="font-medium">UserId:</span> {{ ucfirst($order->userId) }}</p>
            <p><span class="font-medium">Nama:</span> {{ ucfirst($order->name) }}</p>
            <p><span class="font-medium">Jenis:</span> {{ ucfirst($order->type) }}</p>
            <p><span class="font-medium">Antar/Jemput:</span> {{ ucfirst($order->delivery_option) }}</p>
            <p><span class="font-medium">Status Pembayaran:</span> {{ ucfirst($order->status_pembayaran) }}</p>
            <p><span class="font-medium">Total:</span> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            <p><span class="font-medium">Deskripsi:</span> {{ $order->description }}</p>
        </div>

        @if($order->type === 'satuan')
            <div>
                <h3 class="font-semibold text-gray-800 mb-1">Rincian Barang:</h3>
                <ul class="grid grid-cols-2 gap-x-6 gap-y-2 text-gray-600 text-sm list-disc list-inside">
                    @foreach (['baju', 'celana', 'jaket', 'gaun', 'sprey_kasur'] as $item)
                        @if($order->$item)
                            <li>{{ ucfirst($item) }}: {{ $order->$item }} pcs</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @elseif($order->type === 'kiloan')
            <div>
                <p class="text-sm text-gray-700">
                    <span class="font-medium">Berat:</span> {{ $order->weight }} kg
                </p>
            </div>
        @endif

        @if($order->latitude && $order->longitude)
            <div>
                <h3 class="font-semibold text-gray-800 mb-2">Lokasi Pengantaran:</h3>
                <div class="rounded-lg overflow-hidden border">
                    <iframe
                        src="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&hl=es;z=14&output=embed"
                        width="100%" height="300" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
        @endif

        <div class="text-right">
            <a href="{{ route('mindashboard.order.index') }}"
                class="inline-block text-sm text-blue-600 hover:text-blue-800 hover:underline transition">
                ← Kembali ke daftar pesanan
            </a>
        </div>
    </div>
</x-admin-layout>