<?php

namespace App\Http\Controllers\MinDashboard;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

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

    // public function create()
    // {
    //     return view('dashboard.orders.create');
    // }

    // public function store(Request $request)
    // {
    //     // Validate and save
    // }

    // Add more methods as needed (edit, update, destroy...)
}