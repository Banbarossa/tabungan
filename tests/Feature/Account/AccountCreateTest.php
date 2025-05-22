<?php

namespace Tests\Feature\Account;

use App\Livewire\Admin\Account\AccountCreate;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountCreateTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_page_can_be_rendered(): void
    {
        $response = $this->get('/account/create');

        $response->assertStatus(200);
    }


    public function test_page_can_be_create_data(): void
    {
       Livewire::test(AccountCreate::class)
            ->set('name', '')
            ->set('nisn', '')
            ->set('nis', '')
            ->set('nama', '')
            ->set('send_notification', '')
            ->set('notification_target', '')
            ->set('notification_account', '')
            ->call('save')
            ->assertRedirectToRoute('account.');

    }
}
