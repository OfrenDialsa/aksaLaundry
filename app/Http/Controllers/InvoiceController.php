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
            $startLocal = Carbon::createFromFormat('Y-m', $bulanInput, 'Asia/Jakarta')->startOfMonth();
            $endLocal = Carbon::createFromFormat('Y-m', $bulanInput, 'Asia/Jakarta')->endOfMonth();

            $startUtc = $startLocal->copy()->timezone('UTC');
            $endUtc = $endLocal->copy()->timezone('UTC');
        } catch (\Exception $e) {
            abort(400, 'Format bulan tidak valid.');
        }

        $satuan = Price::where('type', 'satuan')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->item => $item->price];
            })
            ->toArray(); 
        $kiloan = Price::where('type', 'kiloan')->value('price'); // ['kiloan' => 8000]

        $orders = Orders::where('status_pembayaran', 'paid')
            ->whereBetween('created_at', [$startUtc, $endUtc])
            ->get();

        $formattedMonth = $startLocal->translatedFormat('F Y'); // e.g. "Juni 2025"

        if ($orders->isEmpty()) {
            $pdf = Pdf::loadView('pdf.monthly_empty', [
                'user' => $user,
                'bulan' => $formattedMonth,
            ]);
        } else {
            $pdf = Pdf::loadView('pdf.monthly', [
                'user' => $user,
                'bulan' => $formattedMonth,
                'orders' => $orders,
                'harga' => [
                    'satuan' => $satuan,
                    'kiloan' => $kiloan
                ]
            ]);
        }

        return $pdf->download("invoice-bulanan-{$bulanInput}.pdf");
    }

}