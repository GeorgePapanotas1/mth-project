<?php

use App\Livewire\Dashboard;
use App\Livewire\Landlord\pages\TenantCreate;
use App\Livewire\Tenant\pages\Companies;
use App\Livewire\Tenant\pages\Projects;
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

        Route::group(['middleware' => ['role:Admin']], function () {
            Route::get('companies', Companies::class)->name(NamedRoutes::COMPANIES);
        });
    });
});

require __DIR__ . '/auth.php';
