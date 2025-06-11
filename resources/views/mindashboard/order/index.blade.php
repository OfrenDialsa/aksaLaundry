<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Pesanan Customer!!') }}
            </h2>
        </div>
    </x-slot>


    <div class="w-full p-6 space-y-10">
        <!-- Section for Satuan Orders -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @php
                $satuanOrders = $orders;
            @endphp
            @forelse ($satuanOrders as $order)
                @php
                    $statusColor = match ($order->status) {
                        'menunggu' => 'from-amber-400 to-yellow-300',
                        'dijemput' => 'from-orange-400 to-orange-300',
                        'diproses' => 'from-sky-500 to-sky-300',
                        'selesai' => 'from-emerald-500 to-green-300',
                        'dibatalkan' => 'from-rose-400 to-red-300',
                        default => 'from-gray-400 to-gray-300',
                    };

                    $orderTypeLabel = $order->type === 'satuan' ? 'Laundry Satuan' : 'Laundry Kiloan';
                @endphp
                <div
                    class="bg-white rounded-2xl shadow-lg p-5 space-y-4 transition-transform duration-300 hover:scale-[1.03] hover:shadow-xl">
                    <div class="bg-gradient-to-r {{ $statusColor }} text-white p-5 shadow-sm rounded">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6 text-white/80" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 6l3 1 2.5-2.5L16 9l2-2 3 3v9a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                                </svg>
                                <h3 class="text-lg font-semibold tracking-wide">{{ $orderTypeLabel }}</h3>
                            </div>

                            @if(in_array($order->status, ['menunggu', 'dibatalkan']))
                                <form action="{{ route('mindashboard.order.destroy', $order->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center space-x-1 text-white/90 hover:text-red-500 text-sm font-medium transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="text-white font-mono text-sm">
                            <p class="flex justify-between">
                                <span>Invoice:</span>
                                <span class="text-right">{{ $order->midtrans_order_id ?? '-' }}</span>
                            </p>
                            <p class="flex justify-between">
                                <span>User ID:</span>
                                <span class="text-right">{{ $order->userId ?? '-' }}</span>
                            </p>
                            <p class="flex justify-between">
                                <span>Nama:</span>
                                <span class="text-right">{{ $order->name ?? '-' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="text-sm text-gray-700 space-y-1">
                        <span class="font-semibold">Pesanan</span>
                        @if($order->type === 'satuan')
                            <div class="text-sm text-gray-700 space-y-1">
                                @if($order->baju)
                                    <p class="flex justify-between"><span>Baju:</span> <span>{{ $order->baju }} pcs</span></p>
                                @endif
                                @if($order->celana)
                                    <p class="flex justify-between"><span>Celana:</span> <span>{{ $order->celana }} pcs</span>
                                    </p>
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
                        @elseif($order->type === 'kiloan')
                            <div class="text-sm text-gray-700 space-y-1">
                                <p class="flex justify-between">
                                    <span>Berat:</span>
                                    <span>{{ $order->weight }} kg</span>
                                </p>
                            </div>
                        @endif
                    </div>

                    <p class="flex justify-between font-medium text-gray-700">
                        <span>Layanan:</span>
                        <span>{{ ucfirst(str_replace('_', ' ', $order->service_type)) }}</span>
                    </p>

                    <p class="flex justify-between font-medium text-gray-700">
                        <span>Antar/Jemput:</span>
                        <span>{{ ucfirst($order->delivery_option) }}</span>
                    </p>

                    <form action="{{ route('mindashboard.order.update', $order->id) }}" method="POST"
                        class="flex justify-between items-center font-semibold">
                        @csrf
                        @method('PUT')
                        <label for="status" class="mr-2">Update Status:</label>
                        <select name="status" onchange="this.form.submit()"
                            class="text-xs font-semibold px-3 py-1 rounded-full text-white {{ $order->status === 'menunggu' ? 'bg-amber-400' : ($order->status === 'dijemput' ? 'bg-orange-400' : ($order->status === 'diproses' ? 'bg-sky-500' : ($order->status === 'selesai' ? 'bg-emerald-500' : 'bg-rose-400'))) }}">

                            <option value="menunggu" {{ $order->status === 'menunggu' ? 'selected' : '' }}>Menunggu
                            </option>

                            {{-- Hanya tampilkan jika antar/jemput = jemput --}}
                            @if($order->delivery_option === 'jemput')
                                <option value="dijemput" {{ $order->status === 'dijemput' ? 'selected' : '' }}>Dijemput
                                </option>
                            @endif

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

                    <p class="text-xs text-gray-500 italic">
                        {{ $order->description }}
                    </p>

                    <div class="flex justify-between items-center text-xs text-gray-400 italic">
                        <a href="{{ route('mindashboard.order.show', $order->id) }}"
                            class="text-blue-500 hover:underline font-medium not-italic">
                            Lihat Detail
                        </a>

                        <p class="text-right">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center text-gray-500 italic select-none">
                    Belum ada pesanan laundry satuan.
                </div>
            @endforelse
        </div>
    </div>
</x-admin-layout>