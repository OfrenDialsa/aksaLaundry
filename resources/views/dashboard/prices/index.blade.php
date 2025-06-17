<x-app-layout>
    <div class="p-8 max-w-6xl mx-auto">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Harga dan Status Layanan') }}
            </h2>
        </x-slot>

        <div class="space-y-8">
            {{-- Layanan Satuan --}}
            @foreach ($satuan as $category => $items)
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-lg font-medium text-gray-600">{{ ucfirst($category) }}</h4>
                        <label class="flex items-center space-x-2 text-sm text-gray-500">
                            <input type="checkbox" class="form-checkbox text-blue-600 cursor-not-allowed" disabled
                                {{ $items->every->is_active ? 'checked' : '' }}>
                            <span>Tersedia</span>
                        </label>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach ($items as $item)
                            <div class="flex flex-col">
                                <label class="text-sm text-gray-500 mb-1 capitalize flex justify-between items-center">
                                    {{ str_replace('_', ' ', $item->item) }}
                                    <span class="flex items-center space-x-2">
                                        <input type="checkbox" {{ $item->is_active ? 'checked' : '' }}
                                            class="hidden" disabled>
                                    </span>
                                </label>
                                <input type="number" value="{{ $item->price }}"
                                    class="border rounded-lg px-3 py-2 bg-gray-100 text-gray-700" readonly disabled>
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
                                    <input type="checkbox" {{ $item->is_active ? 'checked' : '' }}
                                        class="form-checkbox text-blue-600 cursor-not-allowed" disabled>
                                </span>
                            </label>
                            <input type="number" value="{{ $item->price }}"
                                class="border rounded-lg px-3 py-2 bg-gray-100 text-gray-700" readonly disabled>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Biaya Ongkir --}}
            <div class="bg-white p-6 rounded-lg shadow-md mt-8">
                <h3 class="text-2xl font-semibold mb-4 text-gray-700">Biaya Ongkir</h3>

                @if ($ongkir)
                    <div class="flex flex-col md:w-1/2">
                        <label class="text-sm text-gray-500 mb-1 flex justify-between items-center">
                            Ongkir
                            <span class="flex items-center space-x-2">
                                <span class="text-xs text-gray-400">Tersedia</span>
                                <input type="checkbox" {{ $ongkir->is_active ? 'checked' : '' }}
                                    class="form-checkbox text-blue-600 cursor-not-allowed" disabled>
                            </span>
                        </label>
                        <input type="number" value="{{ $ongkir->price }}"
                            class="border rounded-lg px-3 py-2 bg-gray-100 text-gray-700" readonly disabled>
                    </div>
                @else
                    <p class="text-red-500 text-sm">⚠️ Data ongkir belum tersedia di database.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
