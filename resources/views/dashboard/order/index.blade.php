<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <!-- Kiri: Judul & Catatan -->
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Ayo Cuci Laundry') }}
                </h2>
                <p class="text-xs text-gray-400">
                    *Pesanan tidak akan diproses sebelum <span class="text-red-500">pembayaran</span>
                </p>
            </div>

            <!-- Kanan: Tombol dan Info tambahan -->
            <div class="flex flex-col items-start sm:items-end gap-2 text-gray-600 font-medium">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                    <span>Pesan: </span>
                    <a href="{{ route('dashboard.order.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-xl shadow-sm hover:shadow-md transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        Satuan
                    </a>
                </div>

                <!-- Pindahkan tulisan ke bawah tombol -->
                <p class="text-xs text-gray-500">
                    Pesanan Kiloan bisa langsung ke
                    <a href="{{ route('dashboard.ourlocation') }}" class="text-green-500 underline hover:text-green-600">
                        laundry kami
                    </a>
                </p>
            </div>
        </div>
    </x-slot>

    {{-- Filter --}}
    <form method="GET" action="{{ route('dashboard.order.index') }}"
        class="px-6 pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <label for="status" class="text-sm text-gray-700">Filter Status:</label>
            <select name="status" id="status" onchange="this.form.submit()"
                class="text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua</option>
                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="dijemput" {{ request('status') === 'dijemput' ? 'selected' : '' }}>Dijemput</option>
                <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
    </form>

    {{-- Orders --}}
    <div class="w-full px-6 pb-6 pt-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($orders as $order)
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
                            <div class="bg-gradient-to-r {{ $statusColor }} text-white rounded p-5 shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-6 h-6 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 6l3 1 2.5-2.5L16 9l2-2 3 3v9a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                                        </svg>
                                        <h3 class="text-lg font-semibold">{{ $orderTypeLabel }}</h3>
                                    </div>

                                    @if(in_array($order->status, ['menunggu', 'dibatalkan']))
                                        <form action="{{ route('dashboard.order.destroy', $order->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex items-center space-x-1 text-white/90 hover:text-red-500 text-sm font-medium transition">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <p class="font-mono text-xs text-white/80 truncate">
                                    {{ $order->midtrans_order_id ?? '-' }}
                                </p>
                            </div>

                            {{-- Detail --}}
                            <div class="text-sm text-gray-700 space-y-1">
                                @if($order->type === 'satuan')
                                    @foreach (['baju' => 'Baju', 'celana' => 'Celana', 'jaket' => 'Jaket', 'gaun' => 'Gaun', 'sprey_kasur' => 'Sprei Kasur'] as $key => $label)
                                        @if($order->$key)
                                            <p class="flex justify-between font-mono text-gray-500"><span>{{ $label }}:</span>
                                                <span>{{ $order->$key }} pcs</span></p>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="flex justify-between font-mono text-gray-500">
                                        <span>Berat:</span><span>{{ $order->weight }} kg</span></p>
                                @endif
                                <p class="flex justify-between">
                                    <span>Layanan:</span><span>{{ ucfirst(str_replace('_', ' ', $order->service_type)) }}</span></p>
                                <p class="flex justify-between">
                                    <span>Antar/Jemput:</span><span>{{ ucfirst($order->delivery_option) }}</span></p>
                                <p class="flex justify-between"><span>Status:</span>
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full text-white 
                                            {{ match ($order->status) {
                    'menunggu' => 'bg-amber-400',
                    'dijemput' => 'bg-orange-400',
                    'diproses' => 'bg-sky-500',
                    'selesai' => 'bg-emerald-500',
                    'dibatalkan' => 'bg-rose-400',
                    default => 'bg-gray-400'
                } }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                                <p class="flex justify-between font-semibold text-lg text-gray-900">
                                    <span>Total:</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                </p>
                            </div>

                            <p class="text-xs text-gray-500 italic">{{ $order->description }}</p>
                            <div class="flex justify-between items-center text-xs text-gray-400 italic">
                                <a href="{{ route('dashboard.order.show', $order->id) }}"
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
                    Belum ada pesanan laundry.
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>