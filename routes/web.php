<?php

use App\Livewire\Dashboard;
use App\Livewire\Landlord\pages\TenantCreate;
use App\Livewire\Tenant\pages\Companies;
use App\Livewire\Tenant\pages\CreateCompany;
use App\Livewire\Tenant\pages\CreateProject;
use App\Livewire\Tenant\pages\CreateUser;
use App\Livewire\Tenant\pages\Projects;
use App\Livewire\Tenant\pages\UpdateCompany;
use App\Livewire\Tenant\pages\UpdateProject;
use App\Livewire\Tenant\pages\UpdateUser;
use App\Livewire\Tenant\pages\Users;
use Illuminate\Support\Facades\Route;
use Mth\Common\Constants\NamedRoutes;

Route::view('/', 'welcome');

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', Dashboard::class)->name(NamedRoutes::DASHBOARD);
    Route::view('profile', 'profile')->name(NamedRoutes::PROFILE);
    Route::get('tenant/create', TenantCreate::class)->name(NamedRoutes::CREATE_TENANT);

    Route::group(['middleware' => 'tenant'], function () {

        Route::get('users', Users::class)->name(NamedRoutes::USERS);
        Route::get('projects', Projects::class)->name(NamedRoutes::PROJECTS);
        Route::get('projects/create', CreateProject::class)->name(NamedRoutes::PROJECTS_CREATE);
        Route::get('projects/{uuid}/edit', UpdateProject::class)->name(NamedRoutes::PROJECTS_UPDATE);

        Route::group(['middleware' => ['role:Admin']], function () {
            Route::get('companies', Companies::class)->name(NamedRoutes::COMPANIES);
            Route::get('companies/create', CreateCompany::class)->name(NamedRoutes::COMPANIES_CREATE);
            Route::get('companies/{uuid}/edit', UpdateCompany::class)->name(NamedRoutes::COMPANIES_UPDATE);
            Route::get('users/create', CreateUser::class)->name(NamedRoutes::USERS_CREATE);
            Route::get('users/{uuid}/edit', UpdateUser::class)->name(NamedRoutes::USERS_UPDATE);
        });
    });
});

require __DIR__ . '/auth.php';
