<?php

namespace App\Http\Controllers\MinDashboard;

use App\Http\Controllers\Controller;
use App\Models\MinOrders;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MinPaymentController extends Controller
{
    public function index()
    {
        $orders = Orders::latest()->get(); // Ambil semua order
        return view('mindashboard.payment.index', compact('orders'));
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