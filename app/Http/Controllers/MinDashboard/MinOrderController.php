<?php

namespace App\Http\Controllers\MinDashboard;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class MinOrderController extends Controller
{
    public function index()
    {
        $orders = Orders::latest()->get(); // Ambil semua order
        return view('mindashboard.order.index', compact('orders'));
    }

    public function edit($id)
    {
        $order = Orders::findOrFail($id);
        return view('mindashboard.order.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Orders::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        $order->status = $validated['status'];
        $order->save();

        return redirect()->route('mindashboard.order.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();

        return redirect()->route('mindashboard.order.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
