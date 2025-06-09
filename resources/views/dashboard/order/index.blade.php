<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ayo Cuci Laundry') }}
            </h2>
            <div x-data="{ showForm: null }" class="flex items-center space-x-2">
                <span class="text-gray-600 font-medium">Pilih Menu:</span>
                <button @click="showForm = 'satuan'" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Satuan
                </button>
                <button @click="showForm = 'kiloan'"
                    class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">
                    Kiloan
                </button>

                <!-- Modal -->
                <div x-show="showForm" x-cloak x-transition
                    class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                    <div @click.away="showForm = null" class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">

                        <!-- Form Satuan -->
                        <template x-if="showForm === 'satuan'">
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Form Laundry Satuan</h3>
                                <form method="POST" action="{{ route('dashboard.order.store') }}">
                                    @csrf
                                    <input type="hidden" name="type" value="satuan">

                                    <div class="mb-4">
                                        <label class="block text-gray-700">Jumlah Barang (Satuan)</label>
                                        <input type="number" name="quantity" class="w-full border rounded p-2"
                                            placeholder="Masukkan jumlah" required>
                                    </div>

                                    <!-- Antar/Jemput -->
                                    <div class="mb-4">
                                        <span class="block text-gray-700 mb-1">Antar/Jemput</span>
                                        <label class="inline-flex items-center mr-4">
                                            <input type="radio" class="form-radio" name="delivery_option" value="antar"
                                                required>
                                            <span class="ml-2">Antar</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="form-radio" name="delivery_option" value="jemput"
                                                required>
                                            <span class="ml-2">Jemput</span>
                                        </label>
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

                                    <div class="mb-4">
                                        <label class="block text-gray-700">Berat (kg)</label>
                                        <input type="number" step="0.01" name="weight" class="w-full border rounded p-2"
                                            placeholder="Masukkan berat" required>
                                    </div>

                                    <!-- Antar/Jemput -->
                                    <div class="mb-4">
                                        <span class="block text-gray-700 mb-1">Antar/Jemput</span>
                                        <label class="inline-flex items-center mr-4">
                                            <input type="radio" class="form-radio" name="delivery_option" value="antar"
                                                required>
                                            <span class="ml-2">Antar</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="form-radio" name="delivery_option" value="jemput"
                                                required>
                                            <span class="ml-2">Jemput</span>
                                        </label>
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

    <div class="w-full p-6 mt-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($orders as $order)
                <div class="bg-white rounded-xl shadow-md p-4 space-y-1">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-bold text-gray-800">
                            Laundry {{ ucfirst($order->type) }}
                        </h3>
                        <form action="{{ route('dashboard.order.destroy', $order->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                Hapus
                            </button>
                        </form>
                    </div>

                    <p class="flex justify-between">
                        <span class="font-semibold">Jumlah:</span>
                        <span>
                            {{ $order->type === 'satuan' ? $order->quantity . ' pcs' : $order->weight . ' kg' }}
                        </span>
                    </p>

                    <p class="flex justify-between">
                        <span class="font-semibold">Antar/Jemput:</span>
                        <span>{{ ucfirst($order->delivery_option) }}</span>
                    </p>

                    <p class="flex justify-between items-center">
                        <span class="font-semibold">Status:</span>
                        <span
                            class="px-2 py-1 rounded text-white text-sm
                                {{ $order->status === 'menunggu' ? 'bg-yellow-500' : ($order->status === 'diproses' ? 'bg-blue-500' : ($order->status === 'selesai' ? 'bg-green-600' : 'bg-gray-400')) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>

                    <p class="text-sm text-gray-500 mt-2 text-right">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">
                    Belum ada pesanan laundry.
                </div>
            @endforelse
        </div>
    </div>

</x-app-layout>