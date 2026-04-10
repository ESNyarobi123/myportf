<?php

use App\Livewire\Admin\Portfolio\SiteProfileManager;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::actingAs(User::factory()->create())
        ->test(SiteProfileManager::class)
        ->assertOk();
});
