<?php

// use App\Models\Orders;
// use Illuminate\Foundation\Testing\RefreshDatabase;

// uses(RefreshDatabase::class);

// test('it displays orders with jemput delivery and not selesai status', function () {
//     // Orders yang harus tampil
//     Orders::factory()->create([
//         'delivery_option' => 'jemput',
//         'status' => 'menunggu',
//     ]);

//     Orders::factory()->create([
//         'delivery_option' => 'jemput',
//         'status' => 'diproses',
//     ]);

//     // Orders yang tidak boleh tampil
//     Orders::factory()->create([
//         'delivery_option' => 'jemput',
//         'status' => 'selesai',
//     ]);

//     Orders::factory()->create([
//         'delivery_option' => 'antar',
//         'status' => 'menunggu',
//     ]);

//     $response = $this->get(route('mindashboard.location.index'));

//     $response->assertStatus(200);
//     $response->assertViewIs('mindashboard.location.index');

//     // Pastikan hanya order dengan jemput dan bukan selesai yang tampil
//     $orders = $response->viewData('orders');
//     expect($orders)->each(fn ($order) =>
//         expect($order->delivery_option)->toBe('jemput')
//             ->and($order->status)->not->toBe('selesai')
//     );
// });