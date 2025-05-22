<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Volt as LivewireVolt;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_admins_can_authenticate_using_the_login_screen(): void
    {

        $user = User::factory()->create([
            'status'=>true,
            'role'=>'admin'
        ]);

        $user= User::create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'status'=>true,
            'role'=>'admin',
            'password'=>Hash::make('password'),
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login');

        $response
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    }

    public function test_cashiers_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'status'=>true,
            'role'=>'admin'
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login');

        $response
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    }

    public function test_students_can_not_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'status'=>true,
            'role'=>'student'
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login');

        $this->assertGuest();

    }

    public function test_non_active_user_can_not_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'status'=>false,
            'role'=>'student'
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login');

        $this->assertGuest();

    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'status'=>false,
            'role'=>'student'
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $user->email)
            ->set('password', 'wrong-password')
            ->call('login');

        $response->assertHasErrors('email');

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {

        $this->markTestSkipped();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');

        $this->assertGuest();
    }
}
