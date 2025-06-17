<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function index()
    {
        $orders = Orders::where('userId', Auth::id())->latest()->get();
        return view('dashboard.payment.index', compact('orders'));
    }

    public function checkout(Orders $order)
    {
        if ($order->status !== 'menunggu') {
            return response()->json(['error' => 'Pembayaran hanya untuk pesanan dengan status "menunggu".'], 400);
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->midtrans_order_id,
                'gross_amount' => $order->total,
            ],
            'customer_details' => [
                'name' => $order->name,
                'email' => $order->email,
            ],
        ];



        $snapToken = Snap::getSnapToken($params);

        return response()->json(['token' => $snapToken]);
    }


    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        // Ambil data dari request
        $signatureKey = $request->signature_key;
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $transactionStatus = $request->transaction_status;

        // Hitung signature yang benar
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        // Validasi signature
        if ($signatureKey !== $expectedSignature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Temukan order berdasarkan order_id
        $order = Orders::where('midtrans_order_id', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update status berdasarkan status transaksi
        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $order->update([
                'status_pembayaran' => 'paid',
                'status' => 'diproses'
            ]);
        } elseif ($transactionStatus == 'pending') {
            $order->update(['status_pembayaran' => 'pending']);
        } elseif (in_array($transactionStatus, ['cancel', 'expire', 'deny'])) {
            $order->update(['status_pembayaran' => 'unpaid']);
        }

        return response()->json(['message' => 'Callback handled'], 200);
    }
}
