<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $orders = Orders::where('userId', Auth::id())
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(8); // ubah sesuai kebutuhan

        return view('dashboard.order.index', compact('orders', 'status'));
    }

    public function create()
    {
        $satuan = Price::where('type', 'satuan')->get()
            ->groupBy('category')
            ->map(function ($group) {
                return $group->keyBy('item')->map(fn($item) => (float) $item->price); // float
            })->toArray();

        $ongkir = Price::where('type', 'ongkir')->first();

        $activeServices = [
            'cuci' => Price::where('type', 'satuan')->where('category', 'cuci')->value('is_active') ?? false,
            'setrika' => Price::where('type', 'satuan')->where('category', 'setrika')->value('is_active') ?? false,
        ];
        $activeServices['cuci_setrika'] = $activeServices['cuci'] && $activeServices['setrika'];

        return view('dashboard.order.create', compact('satuan', 'ongkir', 'activeServices'));
    }

    public function show($id)
    {
        $order = Orders::where('id', $id)->where('userId', Auth::id())->firstOrFail();
        return view('dashboard.order.show', compact('order'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:satuan',
            'baju' => 'nullable|integer',
            'celana' => 'nullable|integer',
            'jaket' => 'nullable|integer',
            'gaun' => 'nullable|integer',
            'sprey_kasur' => 'nullable|integer',
            'delivery_option' => 'required|in:antar,jemput',
            'service_type' => 'required|in:cuci,setrika,cuci_setrika',
            'description' => 'nullable|string',
            'total' => 'required|integer|min:1',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        if ($request->delivery_option === 'jemput') {
            $request->validate([
                'latitude' => 'required|string',
                'longitude' => 'required|string',
            ]);
        }

        $validated['userId'] = Auth::id();
        $validated['name'] = Auth::user()->name;

        $order = Orders::create($validated);

        // Generate Midtrans Order ID
        $midtransOrderId = 'TEST-' . now()->format('Ymd') . '-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
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
