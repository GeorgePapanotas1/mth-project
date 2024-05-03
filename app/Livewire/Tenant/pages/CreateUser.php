<?php

namespace App\Livewire\Tenant\pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Mth\Common\Constants\NamedRoutes;
use Mth\Tenant\Adapters\Models\User;
use Illuminate\Validation\Rules;
use Mth\Tenant\Core\Dto\User\Forms\CreateUserForm;
use Mth\Tenant\Core\Exceptions\Authorization\UnauthorizedException;
use Mth\Tenant\Core\Services\UserService;

class CreateUser extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    protected readonly UserService $userService;

    public function boot(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function submit()
    {
        $validated = $this->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $userForm = (new CreateUserForm())
            ->setName($validated['name'])
            ->setEmail($validated['email'])
            ->setPassword($validated['password']);

        try {
            $this->userService->create(Auth::user(), $userForm);

            return redirect()->route(NamedRoutes::USERS);
        } catch (UnauthorizedException $e) {
            abort('401');
        }
    }

    public function render()
    {
        return view('livewire.tenant.create-user')->layout('layouts.app');
    }
}
