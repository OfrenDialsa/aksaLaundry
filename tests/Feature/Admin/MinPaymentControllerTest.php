<?php

// use App\Models\Orders;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Support\Carbon;

// uses(RefreshDatabase::class);

// test('it shows orders filtered by given month', function () {
//     // Orders untuk bulan Juni 2025
//     Orders::factory()->create([
//         'created_at' => Carbon::parse('2025-06-10'),
//     ]);

//     // Orders untuk bulan Mei 2025 (tidak boleh tampil)
//     Orders::factory()->create([
//         'created_at' => Carbon::parse('2025-05-15'),
//     ]);

//     $response = $this->get(route('mindashboard.payment.index', ['bulan' => '2025-06']));

//     $response->assertStatus(200);
//     $response->assertViewIs('mindashboard.payment.index');

//     $orders = $response->viewData('orders');
//     expect($orders)->toHaveCount(1);
//     expect($orders->first()->created_at->format('Y-m'))->toBe('2025-06');

//     $response->assertViewHas('bulan', '2025-06');
// });

// test('it defaults to current month when bulan is not provided', function () {
//     // Simulasi bulan sekarang
//     $now = now();

//     Orders::factory()->create([
//         'created_at' => $now->copy()->startOfMonth()->addDays(2),
//     ]);

//     Orders::factory()->create([
//         'created_at' => $now->copy()->subMonth(),
//     ]);

//     $response = $this->get(route('mindashboard.payment.index'));

//     $response->assertStatus(200);

//     $orders = $response->viewData('orders');

//     expect($orders)->each(fn ($order) =>
//         expect($order->created_at->format('Y-m'))->toBe($now->format('Y-m'))
//     );

//     $response->assertViewHas('bulan', $now->format('Y-m'));
// });
