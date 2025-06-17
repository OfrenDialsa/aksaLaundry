<?php

namespace App\Http\Controllers\MinDashboard;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MinPaymentController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter bulan dari query string (jika ada)
        $bulan = $request->bulan ?? now()->format('Y-m');

        // Konversi ke awal dan akhir bulan
        $start = Carbon::parse($bulan)->startOfMonth();
        $end = Carbon::parse($bulan)->endOfMonth();

        // Ambil orders berdasarkan rentang tanggal
        $orders = Orders::whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->get();

        return view('mindashboard.payment.index', [
            'orders' => $orders,
            'bulan' => $bulan,
        ]);
    }
}