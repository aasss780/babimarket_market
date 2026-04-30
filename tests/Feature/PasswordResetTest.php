<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('shows forgot password and validates email', function () {
    $user = User::factory()->create(['email' => 'exists@test.com', 'password' => Hash::make('oldpass')]);

    $this->get('/forgot-password')->assertOk()->assertSee('Forgot password');

    $this->post('/forgot-password', ['email' => 'missing@test.com'])
        ->assertSessionHasErrors('email');

    $this->post('/forgot-password', ['email' => $user->email])
        ->assertRedirect(route('password.reset', ['email' => $user->email]));
});

it('resets password and allows login with new password', function () {
    $user = User::factory()->create([
        'email' => 'reset@test.com',
        'password' => Hash::make('oldpass'),
        'role' => 'customer',
        'status' => 'active',
    ]);

    $this->get(route('password.reset', ['email' => $user->email]))->assertOk()->assertSee('Set new password');

    $this->post('/reset-password', [
        'email' => $user->email,
        'password' => 'newpassword',
        'password_confirmation' => 'wrong',
    ])->assertSessionHasErrors('password');

    $this->post('/reset-password', [
        'email' => $user->email,
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
    ])->assertRedirect(route('login'))->assertSessionHas('success');

    $user->refresh();
    expect(Hash::check('newpassword', $user->password))->toBeTrue();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'newpassword',
    ])->assertRedirect(route('home'));
});

it('redirects reset page without valid email', function () {
    $this->get(route('password.reset', ['email' => 'nobody@test.com']))
        ->assertRedirect(route('password.forgot'));
});
