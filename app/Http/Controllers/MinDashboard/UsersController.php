<?php

namespace App\Http\Controllers\MinDashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->latest()->get(); // Ambil semua order
        return view('mindashboard.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('mindashboard.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return redirect()->route('mindashboard.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('mindashboard.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}