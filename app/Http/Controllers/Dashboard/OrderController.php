<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Orders::where('userId', Auth::id())->latest()->get();
        return view('dashboard.order.index', compact('orders'));
    }

    public function store(Request $request)
    {

        if ($request->type === 'satuan') {
            $validated = $request->validate([
                'type' => 'required|in:satuan,kiloan',
                'baju' => 'nullable|integer',
                'celana' => 'nullable|integer',
                'jaket' => 'nullable|integer',
                'gaun' => 'nullable|integer',
                'sprey_kasur' => 'nullable|integer',
                'delivery_option' => 'required|in:antar,jemput',
                'total' => 'required|integer|min:1'
            ]);
        } elseif ($request->type === 'kiloan') {
            $validated = $request->validate([
                'type' => 'required|in:satuan,kiloan',
                'weight' => 'required|numeric|min:0.1',
                'delivery_option' => 'required|in:antar,jemput',
                'total' => 'required|integer|min:1'
            ]);
        }

        $validated['userId'] = Auth::id();
        $validated['name'] = Auth::user()->name;
        
        // Simpan order awal dulu untuk mendapatkan ID
        $order = Orders::create($validated);

        // Generate Midtrans Order ID (contoh: ORDER-20250609-USER5-ORD23)
        $midtransOrderId = 'INV-' . now()->format('Ymd') . '-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);

        // Update order dengan midtrans_order_id
        $order->midtrans_order_id = $midtransOrderId;
        $order->save();

        return redirect()->route('dashboard.order.index')->with('success', 'Order berhasil disimpan!');
    }

    public function destroy($id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus.');
    }
}