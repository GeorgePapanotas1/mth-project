<?php

namespace App\Livewire\Tenant\components;

use Livewire\Component;

class MultiSelectDropdown extends Component
{
    public $selectedOptions = [];
    public $options = [];

    public function render()
    {
        return view('livewire.tenant.components.multi-select-dropdown');
    }
}
