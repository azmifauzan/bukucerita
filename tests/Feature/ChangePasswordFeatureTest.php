<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('user can access dashboard with change password feature', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
});

test('admin can access admin dashboard with change password feature', function () {
    $admin = User::factory()->create(['email' => 'admin@bukucerita.my.id']);

    $response = $this->actingAs($admin)->get('/admin');

    $response->assertOk();
});

test('password can be updated successfully', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->put('/user/password', [
        'current_password' => 'password',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHasNoErrors();
    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('password update requires correct current password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->put('/user/password', [
        'current_password' => 'wrong-password',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHasErrorsIn('updatePassword', ['current_password']);
    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
});

test('admin can update password successfully', function () {
    $admin = User::factory()->create(['email' => 'admin@bukucerita.my.id']);

    $response = $this->actingAs($admin)->put('/user/password', [
        'current_password' => 'password',
        'password' => 'admin-new-password',
        'password_confirmation' => 'admin-new-password',
    ]);

    $response->assertSessionHasNoErrors();
    expect(Hash::check('admin-new-password', $admin->fresh()->password))->toBeTrue();
});

test('unauthenticated users cannot change password', function () {
    $response = $this->put('/user/password', [
        'current_password' => 'password',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertRedirect();
});
