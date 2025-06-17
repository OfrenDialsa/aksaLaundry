<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it displays the user index page without the current user', function () {
    $authUser = User::factory()->create();
    $otherUser = User::factory()->create();

    $response = $this->actingAs($authUser)->get(route('mindashboard.users.index'));

    $response->assertStatus(200);
    $response->assertViewIs('mindashboard.users.index');

    $users = $response->viewData('users');
    expect($users)->not()->toContain(fn ($user) => $user->id === $authUser->id);
    expect($users)->toContain(fn ($user) => $user->id === $otherUser->id);
});

test('it shows user detail page', function () {
    $authUser = User::factory()->create();
    $targetUser = User::factory()->create();

    $response = $this->actingAs($authUser)->get(route('mindashboard.users.show', $targetUser->id));

    $response->assertStatus(200);
    $response->assertViewIs('mindashboard.users.show');
    $response->assertViewHas('user', $targetUser);
});

test('it can delete other users', function () {
    $authUser = User::factory()->create();
    $targetUser = User::factory()->create();

    $response = $this->actingAs($authUser)->delete(route('mindashboard.users.destroy', $targetUser->id));

    $response->assertRedirect(route('mindashboard.users.index'));
    $response->assertSessionHas('success', 'Pengguna berhasil dihapus.');

    $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
});

test('it prevents deleting own account', function () {
    $authUser = User::factory()->create();

    $response = $this->actingAs($authUser)->delete(route('mindashboard.users.destroy', $authUser->id));

    $response->assertRedirect(route('mindashboard.users.index'));
    $response->assertSessionHas('error', 'Anda tidak dapat menghapus akun Anda sendiri.');

    $this->assertDatabaseHas('users', ['id' => $authUser->id]);
});
