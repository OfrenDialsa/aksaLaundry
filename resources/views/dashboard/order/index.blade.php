<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ayo Cuci Laundry') }}
            </h2>
            <div x-data="{ showForm: null }" class="flex items-center space-x-4">
                <div class="flex items-center gap-2 text-gray-600 font-medium">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                    <span>Pilih Menu:</span>
                </div>
                <button @click="showForm = 'satuan'"
                    class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-xl shadow-sm hover:shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Satuan
                </button>
                <button @click="showForm = 'kiloan'"
                    class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-xl shadow-sm hover:shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    Kiloan
                </button>

                <!-- Modal -->
                <div x-show="showForm" x-cloak x-transition
                    class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                    <div @click.away="showForm = null" class="bg-white w-full max-w-lg mx-4 p-6 rounded-lg shadow-lg">

                        <!-- Form Satuan -->
                        <template x-if="showForm === 'satuan'">
                            <div
                                x-init="$nextTick(() => {['baju', 'celana', 'jaket', 'gaun', 'sprey_kasur'].forEach(id => {document.getElementById(id).addEventListener('input', hitungTotal);});hitungTotal();})">
                                <h3 class="text-lg font-semibold mb-4">Form Laundry Satuan</h3>
                                <form method="POST" action="{{ route('dashboard.order.store') }}">
                                    @csrf
                                    <input type="hidden" name="type" value="satuan">

                                    <!-- Jenis Pakaian -->
                                    <div class="mb-4 flex items-center">
                                        <label for="baju" class="w-40 text-gray-700">Jumlah Baju</label>
                                        <input type="number" name="baju" id="baju" class="flex-1 border rounded p-2">
                                    </div>

                                    <div class="mb-4 flex items-center">
                                        <label for="celana" class="w-40 text-gray-700">Jumlah Celana</label>
                                        <input type="number" name="celana" id="celana"
                                            class="flex-1 border rounded p-2">
                                    </div>

                                    <div class="mb-4 flex items-center">
                                        <label for="jaket" class="w-40 text-gray-700">Jumlah Jaket</label>
                                        <input type="number" name="jaket" id="jaket" class="flex-1 border rounded p-2">
                                    </div>

                                    <div class="mb-4 flex items-center">
                                        <label for="gaun" class="w-40 text-gray-700">Jumlah Gaun</label>
                                        <input type="number" name="gaun" id="gaun" class="flex-1 border rounded p-2">
                                    </div>

                                    <div class="mb-4 flex items-center">
                                        <label for="sprey_kasur" class="w-40 text-gray-700">Jumlah Sprei Kasur</label>
                                        <input type="number" name="sprey_kasur" id="sprey_kasur"
                                            class="flex-1 border rounded p-2">
                                    </div>

                                    <!-- Antar/Jemput -->
                                    <div class="mb-4 flex items-center justify-between">
                                        <span class="block text-gray-700 mb-1">Antar/Jemput</span>
                                        <label class="inline-flex items-center mr-4">
                                            <input type="radio" class="form-radio" name="delivery_option" value="antar"
                                                required>
                                            <span class="ml-2">Antar</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="form-radio" name="delivery_option" value="jemput"
                                                required>
                                            <span class="ml-2">Jemput (+Rp 4.000)</span>
                                        </label>
                                    </div>

                                    <!-- Hasil Total -->
                                    <div class="mb-4">
                                        <label class="block text-gray-700 font-semibold">Total Harga (Rp)</label>
                                        <input type="text" name="total" id="total" readonly
                                            class="w-full border rounded p-2 bg-gray-100 text-gray-700 font-bold">
                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <button type="button" @click="showForm = null"
                                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">Batal</button>
                                        <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </template>


                        <!-- Form Kiloan -->
                        <template x-if="showForm === 'kiloan'">
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Form Laundry Kiloan</h3>
                                <form method="POST" action="{{ route('dashboard.order.store') }}">
                                    @csrf
                                    <input type="hidden" name="type" value="kiloan">

                                    <div class="mb-4 flex items-center">
                                        <label class="block text-gray-700">Berat(kg) </label>
                                        <input type="number" step="0.01" name="weight" class="w-full border rounded p-2"
                                            placeholder="Masukkan berat" required>
                                    </div>

                                    <!-- Antar/Jemput -->
                                    <div class="mb-4 flex items-center justify-between">
                                        <span class="block text-gray-700 mb-1">Antar/Jemput</span>
                                        <label class="inline-flex items-center mr-4">
                                            <input type="radio" class="form-radio" name="delivery_option" value="antar"
                                                required>
                                            <span class="ml-2">Antar</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="form-radio" name="delivery_option" value="jemput"
                                                required>
                                            <span class="ml-2">Jemput (+Rp 4.000)</span>
                                        </label>
                                    </div>

                                    <!-- Hasil Total -->
                                    <div class="mb-4">
                                        <label class="block text-gray-700 font-semibold">Total Harga (Rp)</label>
                                        <input type="text" name="total" id="total" readonly
                                            class="w-full border rounded p-2 bg-gray-100 text-gray-700 font-bold">
                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <button type="button" @click="showForm = null"
                                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">Batal</button>
                                        <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
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
                    @php
                        $statusColor = match ($order->status) {
                            'menunggu' => 'from-amber-400 to-yellow-300',
                            'dijemput' => 'from-orange-400 to-orange-300',
                            'diproses' => 'from-sky-500 to-sky-300',
                            'selesai' => 'from-emerald-500 to-green-300',
                            'dibatalkan' => 'from-rose-400 to-red-300',
                            default => 'from-gray-400 to-gray-300',
                        };
                    @endphp
                    <div
                        class="bg-white rounded-2xl shadow-lg p-5 space-y-4 transition-transform duration-300 hover:scale-[1.03] hover:shadow-xl">
                        <div class="bg-gradient-to-r {{ $statusColor }} text-white p-5 shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-6 h-6 text-white/80" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 6l3 1 2.5-2.5L16 9l2-2 3 3v9a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                                    </svg>
                                    <h3 class="text-lg font-semibold tracking-wide">Laundry Satuan</h3>
                                </div>

                                @if(in_array($order->status, ['menunggu', 'dibatalkan']))
                                    <form action="{{ route('dashboard.order.destroy', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center space-x-1 text-white/90 hover:text-red-500 text-sm font-medium transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <p class="font-mono text-xs tracking-wide text-white/80 truncate">
                                {{ $order->midtrans_order_id ?? '-' }}
                            </p>
                        </div>

                        <div class="text-sm text-gray-700 space-y-1">
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

                        <p class="flex justify-between items-center font-semibold">
                            <span>Status:</span>
                            <span
                                class="text-xs font-semibold px-3 py-1 rounded-full text-white {{ $order->status === 'menunggu' ? 'bg-amber-400' : ($order->status === 'dijemput' ? 'bg-orange-400' : ($order->status === 'diproses' ? 'bg-sky-500' : ($order->status === 'selesai' ? 'bg-emerald-500' : 'bg-rose-400'))) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>

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
                    @php
                        $statusColor = match ($order->status) {
                            'menunggu' => 'from-amber-400 to-yellow-300',
                            'dijemput' => 'from-orange-400 to-orange-300',
                            'diproses' => 'from-sky-500 to-sky-300',
                            'selesai' => 'from-emerald-500 to-green-300',
                            'dibatalkan' => 'from-rose-400 to-red-300',
                            default => 'from-gray-400 to-gray-300',
                        };
                    @endphp
                    <div
                        class="bg-white rounded-2xl shadow-lg p-5 space-y-4 transition-transform duration-300 hover:scale-[1.03] hover:shadow-xl">
                        <div class="bg-gradient-to-r {{ $statusColor }} text-white p-5 shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-6 h-6 text-white/80" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 6l3 1 2.5-2.5L16 9l2-2 3 3v9a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                                    </svg>
                                    <h3 class="text-lg font-semibold tracking-wide">Laundry Kiloan</h3>
                                </div>

                                @if(in_array($order->status, ['menunggu', 'dibatalkan']))
                                    <form action="{{ route('dashboard.order.destroy', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center space-x-1 text-white/90 hover:text-red-500 text-sm font-medium transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <p class="font-mono text-xs tracking-wide text-white/80 truncate">
                                {{ $order->midtrans_order_id ?? '-' }}
                            </p>
                        </div>

                        <p class="text-gray-500 font-mono text-sm truncate">{{ $order->midtrans_order_id ?? '-' }}</p>

                        <p class="flex justify-between font-medium text-gray-700">
                            <span>Berat:</span>
                            <span>{{ $order->weight }} kg</span>
                        </p>

                        <p class="flex justify-between font-medium text-gray-700">
                            <span>Antar/Jemput:</span>
                            <span>{{ ucfirst($order->delivery_option) }}</span>
                        </p>

                        <p class="flex justify-between items-center font-semibold">
                            <span>Status:</span>
                            <span
                                class="text-xs font-semibold px-3 py-1 rounded-full text-white {{ $order->status === 'menunggu' ? 'bg-amber-400' : ($order->status === 'dijemput' ? 'bg-orange-400' : ($order->status === 'diproses' ? 'bg-sky-500' : ($order->status === 'selesai' ? 'bg-emerald-500' : 'bg-rose-400'))) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>

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

    <script>
        const harga = {
            baju: 5000,
            celana: 6000,
            jaket: 8000,
            gaun: 10000,
            sprey_kasur: 12000,
            kiloan: 16000 // harga per kilo
        };

        function hitungTotal() {
            const satuanForm = document.getElementById('baju');
            const kiloanForm = document.querySelector('input[name="weight"]');

            let total = 0;

            if (satuanForm && !satuanForm.closest('[x-cloak][style*="display: none"]')) {
                for (let item of ['baju', 'celana', 'jaket', 'gaun', 'sprey_kasur']) {
                    let jumlah = parseInt(document.getElementById(item).value) || 0;
                    total += jumlah * harga[item];
                }
            } else if (kiloanForm && !kiloanForm.closest('[x-cloak][style*="display: none"]')) {
                let berat = parseFloat(kiloanForm.value) || 0;
                total = berat * harga.kiloan;
            }

            // Tambahkan biaya jemput jika dipilih
            const deliveryOption = document.querySelector('input[name="delivery_option"]:checked');
            if (deliveryOption && deliveryOption.value === 'jemput') {
                total += 4000;
            }

            // Update field total
            let totalInput = document.querySelector('input[name="total"]');
            if (totalInput) {
                totalInput.value = total.toLocaleString('id-ID', { useGrouping: false });
            }
        }

        document.addEventListener('input', (e) => {
            if (
                ['baju', 'celana', 'jaket', 'gaun', 'sprey_kasur', 'weight'].includes(e.target.id) ||
                e.target.name === 'weight' ||
                e.target.name === 'delivery_option'
            ) {
                hitungTotal();
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            ['baju', 'celana', 'jaket', 'gaun', 'sprey_kasur', 'weight'].forEach(idOrName => {
                let el = document.getElementById(idOrName) || document.querySelector(`input[name="${idOrName}"]`);
                if (el) {
                    el.addEventListener('input', hitungTotal);
                }
            });
            hitungTotal();
        });
    </script>
</x-app-layout>