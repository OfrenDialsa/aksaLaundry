<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function index()
    {
        $orders = Orders::where('delivery_option', 'jemput')
            ->where('userId', Auth::id()) // Ganti dengan 'admin_id' jika perlu
            ->whereNotIn('status', ['selesai'])
            ->latest()
            ->get();

        return view('dashboard.location.index', compact('orders'));
    }
}