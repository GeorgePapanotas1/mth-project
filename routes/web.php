<?php

use App\Livewire\Landlord\TenantCreate;
use Illuminate\Support\Facades\Route;
use Mth\Common\Constants\NamedRoutes;

Route::view('/', 'welcome');

Route::group(['middleware' => ['auth']], function () {
    Route::view('dashboard', 'dashboard')->name(NamedRoutes::DASHBOARD);
    Route::view('profile', 'profile')->name(NamedRoutes::PROFILE);
    Route::get('tenant/create', TenantCreate::class)->name(NamedRoutes::CREATE_TENANT);
});

require __DIR__ . '/auth.php';
