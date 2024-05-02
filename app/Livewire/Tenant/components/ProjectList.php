<?php

namespace App\Livewire\Tenant\components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mth\Tenant\Core\Services\ProjectService;

class ProjectList extends Component
{
    public function render(
        ProjectService $projectService
    ) {
        return view('livewire.tenant.components.project-list', [
            'projects' => $projectService->getProjectsPaginated(Auth::user()),
        ]);
    }
}
