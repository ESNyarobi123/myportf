<?php

use App\Livewire\Admin\Portfolio\ServicesManager;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::actingAs(User::factory()->create())
        ->test(ServicesManager::class)
        ->assertOk();
});
