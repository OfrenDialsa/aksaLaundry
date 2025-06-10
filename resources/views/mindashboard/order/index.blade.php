<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Pesanan Customer!!') }}
            </h2>
        </div>
    </x-slot>


    <div class="w-full p-6 mt-5 space-y-10">
        <!-- Section for Satuan Orders -->
        <div>
            <h2 class="text-2xl font-semibold mb-6 text-gray-900 border-b pb-2">Pesanan Laundry Satuan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $satuanOrders = $orders->where('type', 'satuan');
                @endphp
                @forelse ($satuanOrders as $order)
                    <div
                        class="bg-white rounded-2xl shadow-lg p-5 space-y-4 transition-transform duration-300 hover:scale-[1.03] hover:shadow-xl">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-xl font-semibold text-gray-800 tracking-wide">
                                Laundry Satuan
                            </h3>
                            @if(in_array($order->status, ['menunggu', 'selesai', 'dibatalkan']))
                                <form action="{{ route('dashboard.order.destroy', $order->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center space-x-1 text-red-600 hover:text-red-800 text-sm font-medium transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            @endif
                        </div>
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

                        <div class="text-sm text-gray-700 space-y-1">
                            <span class="font-semibold">Pesanan</span>
                            @if($order->baju)
                                <p class="flex justify-between"><span>Baju:</span> <span>{{ $order->baju }} pcs</span></p>
                            @endif
                            @if($order->celana)
                                <p class="flex justify-between"><span>Celana:</span> <span>{{ $order->celana }} pcs</span></p>
                            @endif
                            @if($order->jaket)
                                <p class="flex justify-between"><span>Jaket:</span> <span>{{ $order->jaket }} pcs</span></p>
                            @endif
                            @if($order->gaun)
                                <p class="flex justify-between"><span>Gaun:</span> <span>{{ $order->gaun }} pcs</span></p>
                            @endif
                            @if($order->sprey_kasur)
                                <p class="flex justify-between"><span>Sprei Kasur:</span> <span>{{ $order->sprey_kasur }}
                                        pcs</span></p>
                            @endif
                        </div>

                        <p class="flex justify-between font-medium text-gray-700">
                            <span>Antar/Jemput:</span>
                            <span>{{ ucfirst($order->delivery_option) }}</span>
                        </p>

                        <form action="{{ route('mindashboard.order.update', $order->id) }}" method="POST"
                            class="flex justify-between items-center font-semibold">
                            @csrf
                            @method('PUT')
                            <label for="status" class="mr-2">Status:</label>
                            <select name="status" onchange="this.form.submit()"
                                class="text-xs font-semibold px-3 py-1 rounded-full text-white {{ $order->status === 'menunggu' ? 'bg-yellow-400' : ($order->status === 'diproses' ? 'bg-blue-500' : ($order->status === 'selesai' ? 'bg-green-600' : 'bg-gray-400')) }}">
                                <option value="menunggu" {{ $order->status === 'menunggu' ? 'selected' : '' }}>Menunggu
                                </option>
                                <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses
                                </option>
                                <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan
                                </option>
                            </select>
                        </form>

                        <p class="flex justify-between font-semibold text-gray-900 text-lg">
                            <span>Total:</span>
                            <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </p>

                        <p class="text-gray-400 text-xs text-right italic">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-500 italic select-none">
                        Belum ada pesanan laundry satuan.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Section for Kiloan Orders -->
        <div>
            <h2 class="text-2xl font-semibold mb-6 text-gray-900 border-b pb-2">Pesanan Laundry Kiloan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $kiloanOrders = $orders->where('type', 'kiloan');
                @endphp
                @forelse ($kiloanOrders as $order)
                    <div
                        class="bg-white rounded-2xl shadow-lg p-5 space-y-4 transition-transform duration-300 hover:scale-[1.03] hover:shadow-xl">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-xl font-semibold text-gray-800 tracking-wide">
                                Laundry Kiloan
                            </h3>
                            @if(in_array($order->status, ['menunggu', 'selesai','dibatalkan']))
                                <form action="{{ route('mindashboard.order.destroy', $order->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center space-x-1 text-red-600 hover:text-red-800 text-sm font-medium transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            @endif
                        </div>

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

                        <p class="flex justify-between font-medium text-gray-700">
                            <span>Berat:</span>
                            <span>{{ $order->weight }} kg</span>
                        </p>

                        <p class="flex justify-between font-medium text-gray-700">
                            <span>Antar/Jemput:</span>
                            <span>{{ ucfirst($order->delivery_option) }}</span>
                        </p>

                        <form action="{{ route('mindashboard.order.update', $order->id) }}" method="POST"
                            class="flex justify-between items-center font-semibold">
                            @csrf
                            @method('PUT')
                            <label for="status" class="mr-2">Status:</label>
                            <select name="status" onchange="this.form.submit()"
                                class="text-xs font-semibold px-3 py-1 rounded-full text-white {{ $order->status === 'menunggu' ? 'bg-yellow-400' : ($order->status === 'diproses' ? 'bg-blue-500' : ($order->status === 'selesai' ? 'bg-green-600' : 'bg-gray-400')) }}">
                                <option value="menunggu" {{ $order->status === 'menunggu' ? 'selected' : '' }}>Menunggu
                                </option>
                                <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses
                                </option>
                                <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan
                                </option>
                            </select>
                        </form>

                        <p class="flex justify-between font-semibold text-gray-900 text-lg">
                            <span>Total:</span>
                            <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </p>

                        <p class="text-gray-400 text-xs text-right italic">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-500 italic select-none">
                        Belum ada pesanan laundry kiloan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>