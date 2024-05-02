<?php

namespace App\Livewire\Tenant\pages;

use Livewire\Component;

class Companies extends Component
{
    public function render()
    {
        return view('livewire.tenant.companies')->layout('layouts.app');
    }
}
