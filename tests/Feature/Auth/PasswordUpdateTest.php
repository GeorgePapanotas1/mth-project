<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Volt;
use Mth\Tenant\Adapters\Models\User;
use Tests\Helpers\TestSuite;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
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

    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.update-password-form')
            ->set('current_password', 'password')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('updatePassword');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect();

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.update-password-form')
            ->set('current_password', 'wrong-password')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('updatePassword');

        $component
            ->assertHasErrors(['current_password'])
            ->assertNoRedirect();
    }
}
