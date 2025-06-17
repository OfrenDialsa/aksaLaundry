<?php

namespace App\Http\Controllers;
use App\Models\Orders;
use App\Models\Price;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function download(Orders $order)
    {
        $pdf = Pdf::loadView('pdf.invoice', ['order' => $order]);
        return $pdf->download("invoice-{$order->id}.pdf");
    }

    public function downloadMonthlyInvoice(Request $request)
    {
        $user = Auth::user();
        $bulanInput = $request->input('bulan', now('Asia/Jakarta')->format('Y-m'));

        try {
            // Validasi format bulan: YYYY-MM
            $startLocal = Carbon::createFromFormat('Y-m', $bulanInput, 'Asia/Jakarta')->startOfMonth();
            $endLocal = Carbon::createFromFormat('Y-m', $bulanInput, 'Asia/Jakarta')->endOfMonth();

            $startUtc = $startLocal->copy()->timezone('UTC');
            $endUtc = $endLocal->copy()->timezone('UTC');
        } catch (\Exception $e) {
            abort(400, 'Format bulan tidak valid.');
        }

        // Ambil harga dari database
        $satuan = Price::where('type', 'satuan')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->item => $item->price];
            })
            ->toArray(); // ['baju' => 5000, ...]
        $kiloan = Price::where('type', 'kiloan')->value('price'); // ['kiloan' => 8000]

        // Ambil pesanan user yang sudah dibayar dalam periode tersebut
        $orders = Orders::where('status_pembayaran', 'paid')
            ->whereBetween('created_at', [$startUtc, $endUtc])
            ->get();

        $formattedMonth = $startLocal->translatedFormat('F Y'); // e.g. "Juni 2025"

        if ($orders->isEmpty()) {
            // Jika tidak ada pesanan di bulan tersebut
            $pdf = Pdf::loadView('pdf.monthly_empty', [
                'user' => $user,
                'bulan' => $formattedMonth,
            ]);
        } else {
            // Jika ada pesanan
            $pdf = Pdf::loadView('pdf.monthly', [
                'user' => $user,
                'bulan' => $formattedMonth,
                'orders' => $orders,
                'harga' => [
                    'satuan' => $satuan, // tetap array
                    'kiloan' => $kiloan
                ]
            ]);
        }

        return $pdf->download("invoice-bulanan-{$bulanInput}.pdf");
    }

}