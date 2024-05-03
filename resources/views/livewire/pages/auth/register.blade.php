<?php

use Mth\Tenant\Adapters\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Mth\Landlord\Core\Services\TenancyService;
use Mth\Landlord\Core\Dto\Forms\CreateTenantForm;
use Mth\Landlord\Core\Services\Internal\TenantCrudService;
use \Mth\Tenant\Core\Dto\User\Forms\CreateUserForm;
use Mth\Common\Config\Facades\Config;
use Illuminate\Support\Str;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $domain = '';
    public string $tenantName = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(
        TenancyService $tenancyService,
        TenantCrudService $tenantCrudService,
        \Mth\Tenant\Core\Services\UserService $userService
    ): void {
        
        $this->domain = strtolower(trim(preg_replace('/\s+/', '', $this->domain)));

        $validated = $this->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'   => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'tenantName' => 'required|min:3|max:255',
            'domain'     => 'required|min:3|max:255|unique:tenants,domain',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $tenantForm = (new CreateTenantForm())
            ->setName($this->name)
            ->setDomain($this->domain);

        $userForm = (new CreateUserForm())
            ->setName($validated['name'])
            ->setEmail($validated['email'])
            ->setPassword($validated['password']);

        $newTenant = $tenancyService->registerUserWithTenant($tenantForm, $userForm);

        $tenantDomain = $newTenant->domain . "." . Str::after(Config::config('app.url')->getValue(), '//');
        $this->redirect("http://$tenantDomain/login");
    }
}; ?>

<div>
    <form wire:submit="register">
        <div>
            Account details
        </div>
        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <hr>

        <div class="mt-8">
            Workspace details
        </div>

        <div class="mt-4">
            <x-input-label for="tenant_name" :value="__('Workspace name')"/>

            <x-text-input wire:model="tenantName" id="tenantName" class="block mt-1 w-full"
                          type="text"
                          name="tenantName" required/>

            <x-input-error :messages="$errors->get('tenantName')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="domain" :value="__('Workspace Domain')"/>

            <x-text-input wire:model="domain" id="domain" class="block mt-1 w-full"
                          type="text"
                          name="domain" required/>

            <x-input-error :messages="$errors->get('domain')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
