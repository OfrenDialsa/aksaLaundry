<?php

namespace App\Http\Controllers\MinDashboard;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Price;
use Illuminate\Http\Request;
use App\Models\User;

class MinOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Orders::query();

        if ($request->has('status') && is_array($request->status)) {
            $query->whereIn('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('mindashboard.order.index', compact('orders'));
    }

    public function create()
    {
        $users = User::where('usertype', '!=', 'admin')->get();
        $kiloanPrices = Price::where('type', 'kiloan')->get();

        $ongkir = Price::where('type', 'ongkir')->first();
        $satuan = Price::where('type', 'satuan')->get()
            ->groupBy('category')
            ->map(function ($group) {
                return $group->keyBy('item')->map(function ($item) {
                    return $item->price;
                });
            })->toArray();

        $kiloan = Price::where('type', 'kiloan')->pluck('price', 'category')->toArray();
        $kiloanPrices = Price::where('type', 'kiloan')->get();

        $activeServices = [
            'cuci' => $kiloanPrices->where('category', 'cuci')->first()?->is_active ?? false,
            'setrika' => $kiloanPrices->where('category', 'setrika')->first()?->is_active ?? false,
        ];
        $activeServices['cuci_setrika'] = $activeServices['cuci'] && $activeServices['setrika'];

        return view('mindashboard.order.create', compact('users', 'satuan', 'kiloan', 'ongkir', 'activeServices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'userId' => 'required|exists:users,id',
            'type' => 'required|in:kiloan',
            'weight' => 'required|numeric|min:0.1',
            'delivery_option' => 'required|in:antar,jemput',
            'service_type' => 'required|in:cuci,setrika,cuci_setrika',
            'description' => 'nullable|string',
            'total' => 'required|integer|min:1',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string'
        ]);

        if ($request->delivery_option === 'jemput') {
            $request->validate([
                'latitude' => 'required|string',
                'longitude' => 'required|string'
            ]);
        }

        $user = User::find($validated['userId']);
        $validated['name'] = $user->name;

        // Simpan order
        $order = Orders::create($validated);

        // Buat ID midtrans
        $midtransOrderId = 'TEST-' . now()->format('Ymd') . '-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
        $order->midtrans_order_id = $midtransOrderId;
        $order->save();

        return redirect()->route('mindashboard.order.index')->with('success', 'Order kiloan berhasil disimpan!');
    }


    public function show($id)
    {
        $order = Orders::where('id', $id)->firstOrFail();
        return view('mindashboard.order.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Orders::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:menunggu,dijemput,diproses,selesai,dibatalkan',
        ]);

        $order->status = $validated['status'];
        $order->save();

        $query = [];

        if ($request->has('status')) {
            foreach ((array) $request->input('status') as $filterStatus) {
                $query['status'][] = $filterStatus;
            }
        }

        if ($request->filled('type')) {
            $query['type'] = $request->input('type');
        }

        return redirect()->route('mindashboard.order.index', $query)->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();

        return redirect()->route('mindashboard.order.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
