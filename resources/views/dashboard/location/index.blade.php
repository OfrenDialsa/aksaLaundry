<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lokasi AksaLaundry') }}
        </h2>
    </x-slot>

    <div class="px-4 py-6">
        <!-- Teks Penjelasan di Tengah -->
        <div class="text-center mb-8">
            <p class="text-lg text-gray-700 font-medium">
                Bagi pelanggan yang memilih opsi <span class="font-semibold text-blue-600">antar</span>, silakan mengantarnya ke lokasi di bawah ini:
            </p>
        </div>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Google Maps Lokasi (Kiri) -->
            <div class="w-full md:w-1/2 h-[600px] rounded-xl shadow-lg overflow-hidden bg-white">
                <iframe
                    class="w-full h-full border-0"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d249.26364795845592!2d103.54113353462789!3d-1.6226662294371572!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sid!4v1749575524267!5m2!1sen!2sid"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <!-- Google Street View (Kanan) -->
            <div class="w-full md:w-1/2 h-[600px] rounded-xl shadow-lg overflow-hidden bg-white">
                <iframe
                    class="w-full h-full border-0"
                    src="https://www.google.com/maps/embed?pb=!4v1749575946982!6m8!1m7!1sOV92CkUX2LMYjSowbcOgzA!2m2!1d-1.622760156469893!2d103.5411668963064!3f41.93247912932238!4f-2.1486522527601295!5f0.7820865974627469"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</x-app-layout>
