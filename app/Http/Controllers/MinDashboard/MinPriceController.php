<?php

namespace App\Http\Controllers\MinDashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;

class MinPriceController extends Controller
{
    public function index()
    {
        $satuan = Price::where('type', 'satuan')->orderBy('category')->get()->groupBy('category');
        $kiloan = Price::where('type', 'kiloan')->get();
        $ongkir = Price::where('type', 'ongkir')->first();

        return view('mindashboard.prices.index', compact('satuan', 'kiloan', 'ongkir'));
    }

    public function update(Request $request)
    {
        $prices = $request->input('prices', []);
        $actives = $request->input('actives', []);

        foreach ($prices as $id => $price) {
            $priceModel = Price::find($id);
            if ($priceModel) {
                $priceModel->price = $price;
                $priceModel->is_active = isset($actives[$id]) ? 1 : 0;
                $priceModel->save();
            }
        }

        return redirect()->back()->with('success', 'Harga dan status layanan berhasil diperbarui.');
    }
}
