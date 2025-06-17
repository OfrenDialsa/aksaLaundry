<x-admin-layout>
    <div class="max-w-2xl mx-auto mt-20 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-6">Detail Pengguna</h2>

        <div class="space-y-4">
            <div>
                <span class="text-gray-600 font-medium">Nama:</span>
                <p class="text-gray-900">{{ $user->name }}</p>
            </div>

            <div>
                <span class="text-gray-600 font-medium">Email:</span>
                <p class="text-gray-900">{{ $user->email }}</p>
            </div>

            <div>
                <span class="text-gray-600 font-medium">Tanggal Daftar:</span>
                <p class="text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
            </div>

            <div>
                <span class="text-gray-600 font-medium">Terakhir Diupdate:</span>
                <p class="text-gray-900">{{ $user->updated_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('mindashboard.users.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">Kembali</a>
        </div>
    </div>
</x-admin-layout>