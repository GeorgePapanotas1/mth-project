<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\Helpers\TestSuite;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    // TODO Modify to work on tenant
    public function setUp(): void
    {
        parent::setUp();
        TestSuite::refreshDatabaseAsTenant();
    }
    public function tearDown(): void
    {
        parent::tearDown();
        TestSuite::cleanDatabase();
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.register');
    }

    public function test_new_users_can_register(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password');

        $component->call('register');

        $component->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    }
}
