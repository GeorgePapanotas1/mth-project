<?php

namespace App\Livewire\Tenant\pages;

use Livewire\Component;

class Projects extends Component
{
    public function render()
    {
        return view('livewire.tenant.projects')->layout('layouts.app');
    }
}
