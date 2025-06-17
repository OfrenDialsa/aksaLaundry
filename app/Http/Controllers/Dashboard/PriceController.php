<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;

class PriceController extends Controller
{
    public function index()
    {
        $satuan = Price::where('type', 'satuan')->orderBy('category')->get()->groupBy('category');
        $kiloan = Price::where('type', 'kiloan')->get();
        $ongkir = Price::where('type', 'ongkir')->first();

        return view('dashboard.prices.index', compact('satuan', 'kiloan', 'ongkir'));
    }
}
