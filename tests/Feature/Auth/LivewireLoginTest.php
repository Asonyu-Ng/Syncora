<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_via_livewire_login_with_email(): void
    {
        $user = User::factory()->create([
            'email' => 'student@example.com',
            'role' => 'student',
        ]);

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('authenticate')
            ->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }
}
