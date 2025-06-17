<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Ayo Cuci Laundry') }}
                </h2>
                <p class="text-xs text-gray-400">*Pesanan tidak akan diproses sebelum <span class="text-red-500">pembayaran</span></p>
            </div>

            <div class="flex items-center space-x-4">
                <div class="flex items-center gap-2 text-gray-600 font-medium">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                    <span>Tambahkan pesanan:</span>
                </div>
                <a href="{{ route('mindashboard.order.create') }}"
                    class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-xl shadow-sm hover:shadow-md transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    Kiloan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="w-full p-4 sm:p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            {{-- Sidebar Filter --}}
            <div class="md:col-span-1 w-full bg-white p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Filter Pesanan</h3>

                <form method="GET" action="{{ route('mindashboard.order.index') }}" class="space-y-4">
                    @php $statuses = ['menunggu', 'dijemput', 'diproses', 'selesai', 'dibatalkan']; @endphp

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Status --}}
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Status</h4>
                            <div class="space-y-2">
                                @foreach ($statuses as $status)
                                    <label class="flex items-center space-x-2 text-sm">
                                        <input type="checkbox" name="status[]" value="{{ $status }}"
                                            {{ in_array($status, request()->get('status', [])) ? 'checked' : '' }}
                                            class="form-checkbox text-blue-600 border-gray-300">
                                        <span class="capitalize text-gray-700">{{ $status }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Jenis Pesanan --}}
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Jenis Pesanan</h4>
                            <div class="space-y-2">
                                <label class="flex items-center space-x-2 text-sm">
                                    <input type="radio" name="type" value="kiloan"
                                        {{ request('type') === 'kiloan' ? 'checked' : '' }}
                                        class="form-radio text-blue-600 border-gray-300">
                                    <span>Kiloan</span>
                                </label>
                                <label class="flex items-center space-x-2 text-sm">
                                    <input type="radio" name="type" value="satuan"
                                        {{ request('type') === 'satuan' ? 'checked' : '' }}
                                        class="form-radio text-blue-600 border-gray-300">
                                    <span>Satuan</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="space-y-2">
                        <button type="submit"
                            class="w-full py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md text-sm font-medium">
                            Terapkan Filter
                        </button>

                        <a href="{{ route('mindashboard.order.index') }}"
                            class="block w-full text-center text-xs text-red-600 hover:underline">
                            Reset Filter
                        </a>
                    </div>
                </form>
            </div>

            {{-- Main Content --}}
            <div class="md:col-span-2 lg:col-span-3">
                <div class="bg-white rounded-lg shadow overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 font-semibold">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Invoice</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Jenis</th>
                                <th class="px-4 py-3">Detail</th>
                                <th class="px-4 py-3">Layanan</th>
                                <th class="px-4 py-3">Antar/Jemput</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($orders as $i => $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $orders->firstItem() + $i }}</td>
                                    <td class="px-4 py-3">{{ $order->midtrans_order_id ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $order->name ?? '-' }}</td>
                                    <td class="px-4 py-3 capitalize">{{ $order->type }}</td>
                                    <td class="px-4 py-3">
                                        @if ($order->type === 'satuan')
                                            <ul class="list-disc ml-5 text-xs">
                                                @foreach (['baju', 'celana', 'jaket', 'gaun', 'sprey_kasur'] as $item)
                                                    @if ($order->$item)
                                                        <li>{{ ucfirst(str_replace('_', ' ', $item)) }}: {{ $order->$item }} pcs</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-xs">Berat: {{ $order->weight ?? 0 }} kg</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 capitalize">{{ str_replace('_', ' ', $order->service_type) }}</td>
                                    <td class="px-4 py-3 capitalize">{{ $order->delivery_option }}</td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('mindashboard.order.update', $order->id) }}" method="POST">
                                            @csrf @method('PUT')

                                            @foreach(request()->get('status', []) as $filterStatus)
                                                <input type="hidden" name="status[]" value="{{ $filterStatus }}">
                                            @endforeach
                                            @if(request()->filled('type'))
                                                <input type="hidden" name="type" value="{{ request('type') }}">
                                            @endif

                                            <select name="status" onchange="this.form.submit()"
                                                class="text-xs bg-white border border-gray-300 rounded px-2 py-1">
                                                <option value="menunggu" {{ $order->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                @if ($order->delivery_option === 'jemput')
                                                    <option value="dijemput" {{ $order->status === 'dijemput' ? 'selected' : '' }}>Dijemput</option>
                                                @endif
                                                <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-gray-900">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('mindashboard.order.show', $order->id) }}"
                                                class="text-blue-600 hover:underline text-xs">Detail</a>

                                            @if(in_array($order->status, ['menunggu', 'dibatalkan']))
                                                <form action="{{ route('mindashboard.order.destroy', $order->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-500 hover:underline text-xs">Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center italic py-6 text-gray-500">
                                        Belum ada pesanan ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if ($orders->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $orders->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
