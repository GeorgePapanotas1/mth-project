<?php

namespace App\Livewire\Tenant\pages;

use Livewire\Component;

class Users extends Component
{
    public function render()
    {
        return view('livewire.tenant.users')->layout('layouts.app');
    }
}
