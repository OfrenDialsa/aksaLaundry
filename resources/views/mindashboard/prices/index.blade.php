<x-admin-layout>
    <div class="p-8 max-w-6xl mx-auto">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Edit harga dan status') }}
            </h2>
        </x-slot>

        @if (session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('mindashboard.prices.update') }}" class="space-y-8">
            @csrf

            {{-- Layanan Satuan --}}
            @foreach ($satuan as $category => $items)
                <div class="mb-6" x-data="{ toggle: false }" x-init="
                            // Inisialisasi toggle berdasarkan semua item aktif
                            toggle = {{ $items->every->is_active ? 'true' : 'false' }};
                        " x-effect="
                            // Setiap kali toggle berubah, ubah semua checkbox di dalamnya
                            $el.querySelectorAll('input[type=checkbox][data-category=\'{{ $category }}\']').forEach(c => c.checked = toggle);
                        ">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-lg font-medium text-gray-600">{{ ucfirst($category) }}</h4>
                        <label class="flex items-center space-x-2 text-sm text-gray-500">
                            <input type="checkbox" x-model="toggle" class="form-checkbox text-blue-600">
                            <span>Tersedia</span>
                        </label>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach ($items as $item)
                            <div class="flex flex-col">
                                <label class="text-sm text-gray-500 mb-1 capitalize flex justify-between items-center">
                                    {{ str_replace('_', ' ', $item->item) }}
                                    <span class="flex items-center space-x-2">
                                        <input type="checkbox" name="actives[{{ $item->id }}]" value="1"
                                            data-category="{{ $category }}" {{ $item->is_active ? 'checked' : '' }}
                                            class="hidden">
                                    </span>
                                </label>
                                <input type="number" name="prices[{{ $item->id }}]" value="{{ $item->price }}"
                                    class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Layanan Kiloan --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold mb-4 text-gray-700">Layanan Kiloan</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach ($kiloan as $item)
                        <div class="flex flex-col">
                            <label class="text-sm text-gray-500 mb-1 capitalize flex justify-between items-center">
                                {{ ucfirst($item->category) }}
                                <span class="flex items-center space-x-2">
                                    <span class="text-xs text-gray-400">Tersedia</span>
                                    <input type="checkbox" name="actives[{{ $item->id }}]" value="1" {{ $item->is_active ? 'checked' : '' }} class="form-checkbox text-blue-600">
                                </span>
                            </label>
                            <input type="number" name="prices[{{ $item->id }}]" value="{{ $item->price }}"
                                class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Harga Ongkir --}}
            <div class="bg-white p-6 rounded-lg shadow-md mt-8">
                <h3 class="text-2xl font-semibold mb-4 text-gray-700">Biaya Ongkir</h3>

                @if ($ongkir)
                    <div class="flex flex-col md:w-1/2">
                        <label class="text-sm text-gray-500 mb-1 flex justify-between items-center">
                            Ongkir
                            <span class="flex items-center space-x-2">
                                <span class="text-xs text-gray-400">Tersedia</span>
                                <input type="checkbox" name="actives[{{ $ongkir->id }}]" value="1"
                                    {{ $ongkir->is_active ? 'checked' : '' }} class="form-checkbox text-blue-600">
                            </span>
                        </label>
                        <input type="number" name="prices[{{ $ongkir->id }}]" value="{{ $ongkir->price }}"
                            class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                @else
                    <p class="text-red-500 text-sm">⚠️ Data ongkir belum tersedia di database.</p>
                @endif
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-all">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>