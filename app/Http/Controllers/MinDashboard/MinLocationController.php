<?php

namespace App\Http\Controllers\MinDashboard;

use App\Http\Controllers\Controller;
use App\Models\Orders;

class MinLocationController extends Controller
{
    public function index()
    {
        $orders = Orders::where('delivery_option', 'jemput')
            ->whereNotIn('status', [ 'selesai'])
            ->latest()
            ->get();

        return view('mindashboard.location.index', compact('orders'));
    }
}