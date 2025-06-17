<?php

use App\Models\Orders;
use App\Models\Price;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Setup global sebelum semua test
beforeEach(function () {
    User::factory()->create(['usertype' => 'user']);
    User::factory()->create(['usertype' => 'admin']);

    Price::factory()->create(['type' => 'kiloan', 'category' => 'cuci', 'is_active' => true]);
    Price::factory()->create(['type' => 'kiloan', 'category' => 'setrika', 'is_active' => true]);
});

test('it displays order index page', function () {
    $response = $this->get(route('mindashboard.order.index'));

    $response->assertStatus(200);
    $response->assertViewIs('mindashboard.order.index');
});

test('it can create a new order', function () {
    $user = User::where('usertype', 'user')->first();

    $data = [
        'userId' => $user->id,
        'type' => 'kiloan',
        'weight' => 2.5,
        'delivery_option' => 'antar',
        'service_type' => 'cuci',
        'total' => 15000,
        'description' => 'Test order kiloan',
    ];

    $response = $this->post(route('mindashboard.order.store'), $data);

    $response->assertRedirect(route('mindashboard.order.index'));
    expect(Orders::where('userId', $user->id)->where('type', 'kiloan')->exists())->toBeTrue();
});

test('it requires lat long if delivery option is jemput', function () {
    $user = User::where('usertype', 'user')->first();

    $response = $this->post(route('mindashboard.order.store'), [
        'userId' => $user->id,
        'type' => 'kiloan',
        'weight' => 2.5,
        'delivery_option' => 'jemput',
        'service_type' => 'setrika',
        'total' => 10000,
    ]);

    $response->assertSessionHasErrors(['latitude', 'longitude']);
});

test('it can show order detail', function () {
    $order = Orders::factory()->create();

    $response = $this->get(route('mindashboard.order.show', $order->id));

    $response->assertStatus(200);
    $response->assertViewIs('mindashboard.order.show');
    $response->assertViewHas('order', $order);
});

test('it can update order status', function () {
    $order = Orders::factory()->create(['status' => 'menunggu']);

    $response = $this->patch(route('mindashboard.order.update', $order->id), [
        'status' => 'diproses',
    ]);

    $response->assertRedirect();
    expect($order->fresh()->status)->toBe('diproses');
});

test('it can delete an order', function () {
    $order = Orders::factory()->create();

    $response = $this->delete(route('mindashboard.order.destroy', $order->id));

    $response->assertRedirect(route('mindashboard.order.index'));
    $this->assertDatabaseMissing('orders', ['id' => $order->id]);
});