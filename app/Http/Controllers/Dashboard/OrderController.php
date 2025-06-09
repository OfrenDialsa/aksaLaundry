<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('userId', Auth::id())->latest()->get();
        return view('dashboard.order.index', compact('orders'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'type' => 'required|in:satuan,kiloan',
            'baju' => 'nullable|integer|required_if:type,satuan|min:1',
            'celana' => 'nullable|integer|required_if:type,satuan|min:1,',
            'jaket' => 'nullable|integer|required_if:type,satuan|min:1',
            'gaun' => 'nullable|integer|required_if:type,satuan|min:1',
            'sprey_kasur' => 'nullable|integer|required_if:type,satuan|min:1',
            'weight' => 'nullable|numeric|required_if:type,kiloan|min:0.1',
            'delivery_option' => 'required|in:antar,jemput',
        ]);

        $validated['userId'] = Auth::id();
        $validated['name'] = Auth::user()->name;

        Order::create($validated);

        return redirect()->route('dashboard.order.index')->with('success', 'Order berhasil disimpan!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus.');
    }
}