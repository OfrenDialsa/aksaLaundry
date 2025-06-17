<?php

use App\Models\Price;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it displays the price index page with satuan, kiloan, and ongkir', function () {
    Price::factory()->create(['type' => 'satuan', 'category' => 'kaos']);
    Price::factory()->create(['type' => 'kiloan', 'category' => 'cuci']);
    Price::factory()->create(['type' => 'ongkir', 'category' => 'delivery']);

    $response = $this->get(route('mindashboard.prices.index'));

    $response->assertStatus(200);
    $response->assertViewIs('mindashboard.prices.index');
    $response->assertViewHasAll(['satuan', 'kiloan', 'ongkir']);
});

test('it updates prices and their activation status', function () {
    $priceSatuan = Price::factory()->create(['type' => 'satuan', 'price' => 10000, 'is_active' => true]);
    $priceKiloan = Price::factory()->create(['type' => 'kiloan', 'price' => 15000, 'is_active' => false]);
    $priceOngkir = Price::factory()->create(['type' => 'ongkir', 'price' => 5000, 'is_active' => true]);

    $response = $this->post(route('mindashboard.prices.update'), [
        'prices' => [
            $priceSatuan->id => 12000,
            $priceKiloan->id => 18000,
            $priceOngkir->id => 8000,
        ],
        'actives' => [
            $priceSatuan->id => 'on',
            // priceKiloan tidak aktif
            $priceOngkir->id => 'on',
        ],
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Harga dan status layanan berhasil diperbarui.');

    expect(Price::find($priceSatuan->id)->price)->toBe(12000)
        ->and(Price::find($priceSatuan->id)->is_active)->toBe(1);

    expect(Price::find($priceKiloan->id)->price)->toBe(18000)
        ->and(Price::find($priceKiloan->id)->is_active)->toBe(0);

    expect(Price::find($priceOngkir->id)->price)->toBe(8000)
        ->and(Price::find($priceOngkir->id)->is_active)->toBe(1);
});
