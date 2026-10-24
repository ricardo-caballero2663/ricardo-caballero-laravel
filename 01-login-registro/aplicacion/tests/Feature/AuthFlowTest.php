<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_home(): void
    {
        $this->get('/home')->assertRedirect('/login');
    }

    public function test_user_can_register_and_password_is_hashed(): void
    {
        $this->post('/register', ['name' => 'Usuario de prueba', 'email' => 'demo@example.test', 'password' => 'Prueba2026!', 'password_confirmation' => 'Prueba2026!'])->assertRedirect('/home');
        $user = User::where('email', 'demo@example.test')->firstOrFail();
        $this->assertTrue(Hash::check('Prueba2026!', $user->password));
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        User::factory()->create(['email' => 'demo@example.test', 'password' => Hash::make('Prueba2026!')]);
        $this->post('/login', ['email' => 'demo@example.test', 'password' => 'incorrecta'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_and_logout(): void
    {
        $user = User::factory()->create(['email' => 'demo@example.test', 'password' => Hash::make('Prueba2026!')]);
        $this->post('/login', ['email' => $user->email, 'password' => 'Prueba2026!'])->assertRedirect('/home');
        $this->get('/home')->assertOk();
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_duplicate_email_is_rejected(): void
    {
        User::factory()->create(['email' => 'demo@example.test']);
        $this->post('/register', ['name' => 'Demo', 'email' => 'demo@example.test', 'password' => 'Prueba2026!', 'password_confirmation' => 'Prueba2026!'])->assertSessionHasErrors('email');
    }
}
