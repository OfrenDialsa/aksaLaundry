{{-- resources/views/admin/order-kiloan-create.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="text-left">
            <a href="{{ route('mindashboard.order.index') }}"
                class="inline-block text-sm text-blue-600 hover:text-blue-800 hover:underline transition">
                ← Kembali ke daftar pesanan
            </a>
        </div>
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Form Laundry Kiloan') }}
        </h2>
    </x-slot>

    <div class="py-6 px-12 bg-white rounded-xl shadow-md" x-data="{
        delivery_option: '',
        getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    if (window.map && window.marker) {
                        map.setCenter(userLocation);
                        marker.setPosition(userLocation);
                        updateLatLngInputs(userLocation.lat, userLocation.lng);
                    }
                }, () => alert('Gagal mendapatkan lokasi.'));
            } else {
                alert('Geolocation tidak didukung oleh browser ini.');
            }
        }
    }">

        <form method="POST" action="{{ route('mindashboard.order.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="type" value="kiloan">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                    <input type="number" step="0.01" name="weight"
                        class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Pilih User</label>
                    <select name="userId"
                        class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                        required>
                        <option value="" disabled selected>Pilih user...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} (ID: {{ $user->id }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Layanan -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Layanan</label>
                <div class="flex flex-wrap gap-4">
                    @php
                        $services = ['cuci' => 'Cuci', 'setrika' => 'Setrika', 'cuci_setrika' => 'Cuci + Setrika'];
                    @endphp
                    @foreach ($services as $key => $label)
                        <label class="flex items-center px-4 py-2 rounded-xl border transition 
                            {{ $activeServices[$key] ? 'cursor-pointer bg-white border-gray-300 hover:bg-blue-50' : 'bg-gray-100 border-gray-200 cursor-not-allowed' }}">
                            <input
                                type="radio"
                                name="service_type"
                                value="{{ $key }}"
                                class="form-radio text-blue-600 focus:ring-blue-500"
                                {{ !$activeServices[$key] ? 'disabled' : '' }}
                            >
                            <span class="ml-2 text-sm {{ !$activeServices[$key] ? 'text-gray-400' : 'text-gray-800' }}">
                                {{ $label }}
                            </span>
                        </label>
                    @endforeach
                </div>
                @if (!($activeServices['cuci'] || $activeServices['setrika'] || $activeServices['cuci_setrika']))
                    <p class="text-sm text-red-500 mt-2">⚠️ Semua layanan saat ini tidak tersedia.</p>
                @endif
            </div>

            <!-- Antar/Jemput -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Antar/Jemput</label>
                <div class="flex gap-6">
                    <label class="inline-flex items-center space-x-2">
                        <input type="radio" name="delivery_option" value="antar" x-model="delivery_option"
                            class="text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span>Antar</span>
                    </label>
                    <label class="inline-flex items-center space-x-2">
                        <input type="radio" name="delivery_option" value="jemput" x-model="delivery_option"
                            @change="getLocation()"
                            class="text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span>Jemput (+Rp. {{ number_format($ongkir->price ?? 0) }})</span>
                    </label>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    <span class="font-semibold text-blue-500">(i)</span> Sistem akan melacak lokasi Anda jika memilih jemput.
                </p>

                <div class="mt-4" x-show="delivery_option === 'jemput'" x-transition>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Lokasi Penjemputan</label>
                    <div id="map" x-ref="mapContainer" class="w-full h-64 rounded-xl border-2 border-gray-300"></div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi Tambahan</label>
                <textarea name="description" rows="3"
                    class="mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    placeholder="Contoh: Harap disetrika halus..."></textarea>
            </div>

            <!-- Total -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Total Harga (Rp)</label>
                <input type="text" name="total" id="total" readonly
                    class="mt-1 w-full bg-gray-100 border border-gray-300 rounded-xl p-2 font-semibold text-blue-700">
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('mindashboard.order.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-xl shadow-sm">Batal</a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-xl shadow-md">Kirim</button>
            </div>
        </form>
    </div>

    {{-- SCRIPT Harga & Total --}}
    <script>
        const harga = {
            satuan: @json($satuan ?? []),
            kiloan: @json($kiloan ?? []),
            ongkir: @json($ongkir->price ?? 0)
        };

        function hitungTotal() {
            const kiloanForm = document.querySelector('input[name="weight"]');
            const serviceType = document.querySelector('input[name="service_type"]:checked');
            let total = 0;
            let layanan = serviceType ? serviceType.value : 'cuci';

            if (kiloanForm) {
                const berat = parseFloat(kiloanForm.value) || 0;
                if (layanan === 'cuci' || layanan === 'setrika') {
                    total = berat * harga.kiloan[layanan];
                } else if (layanan === 'cuci_setrika') {
                    total = berat * (harga.kiloan.cuci + harga.kiloan.setrika);
                }
            }

            const deliveryOption = document.querySelector('input[name="delivery_option"]:checked');
            if (deliveryOption?.value === 'jemput') total += harga.ongkir;

            const totalInput = document.querySelector('input[name="total"]');
            if (totalInput) totalInput.value = total.toLocaleString('id-ID', { useGrouping: false });
        }

        document.addEventListener('input', (e) => {
            if (
                ['weight'].includes(e.target.name) ||
                ['service_type', 'delivery_option'].includes(e.target.name)
            ) {
                hitungTotal();
            }
        });

        document.addEventListener('DOMContentLoaded', hitungTotal);
    </script>

    {{-- SCRIPT Google Maps --}}
    <script>
        let map, marker;

        function initMap() {
            const jambiPosition = { lat: -1.610122, lng: 103.613120 };
            const mapDiv = document.getElementById("map");

            if (!mapDiv) {
                const checkExist = setInterval(() => {
                    const m = document.getElementById("map");
                    if (m) {
                        clearInterval(checkExist);
                        initMap();
                    }
                }, 100);
                return;
            }

            map = new google.maps.Map(mapDiv, {
                zoom: 15,
                center: jambiPosition,
            });

            marker = new google.maps.Marker({
                position: jambiPosition,
                map: map,
                draggable: true,
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const currentPos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(currentPos);
                        marker.setPosition(currentPos);
                        updateLatLngInputs(currentPos.lat, currentPos.lng);
                    },
                    () => updateLatLngInputs(jambiPosition.lat, jambiPosition.lng)
                );
            } else {
                updateLatLngInputs(jambiPosition.lat, jambiPosition.lng);
            }

            google.maps.event.addListenerOnce(map, 'idle', () => {
                google.maps.event.trigger(map, 'resize');
                map.setCenter(marker.getPosition());
            });

            marker.addListener('dragend', () => {
                const pos = marker.getPosition();
                updateLatLngInputs(pos.lat(), pos.lng());
            });
        }

        function updateLatLngInputs(lat, lng) {
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
        }

        window.initMap = initMap;
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemap.map_api') }}&callback=initMap" async defer></script>
</x-admin-layout>
